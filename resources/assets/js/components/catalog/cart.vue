<template lang="html">
    <div>
        <div class="text-center">
            <spinner v-if="loading"></spinner>
        </div>

        <div class="empty-heading" v-if="emptycart && ! loading">
            סל הקניות שלך ריק
        </div>

        <div class="row">
            <table class="table cart-items table-childrow" v-if="!emptycart">
                <tr class="tblheader">
                    <th>
                        מוצר
                    </th>
                    <th>
                        פעולה
                    </th>
                    <th>
                        מחיר
                    </th>
                </tr>
                <tr v-for="(cartpk, index) in cartPackages">
                    <td>
                        <b>
                            {{ cartpk.items.foreign_name }}<br />
                            {{ cartpk.items.description }}<br />
                            {{ cartpk.items.id }}<br />
                            שרת מארח: {{ cartpk.ip_host }}<br />

                            <div v-if="isUserConnected">
                                <span class="small-link">הגדר דומיין לחבילה</span>
                                <selectPackDomain :cartpk="cartpk" :i="index" />
                            </div>
                        </b>
                        <div class="addon-details" v-for="addon in cartpk.item_addons" v-if="! addon.id.includes('BT')">
                            {{ addon.foreign_name + ' (' + addon.price + '₪ כפול ' + addon.pivot.value + ' יח)' }}
                        </div>
                        <div class="addon-details" v-for="addon in cartpk.item_addons" v-if="addon.id.includes('BT')">
                            {{ addon.foreign_name }}<br />
                            מחיר לשעה: {{ addon.price }}<br />
                            כמות שעות: {{ addon.pivot.total_hours }}<br />
                            עד לתאריך: {{ addon.pivot.end_date }}<br />
                            כמות יחידות: {{ addon.pivot.value }}<br />
                            סך הכל: {{ addon.pivot.total_hours * addon.pivot.value * addon.price | currency }}
                        </div>
                    </td>
                    <td>
                        <a class="button small" @click.prevent="wizard(cartpk.id)"><i class="fa fa-cogs" aria-hidden="true"></i> שינוי הגדרות החבילה</a>
                    </td>
                    <td>
                        מחיר החבילה {{ cartpk.items.price | currency }}<br />
                        מחיר התוספות {{ calcAddonPrice(cartpk.item_addons) | currency }}<br />
                        <b>סה"כ {{ cartpk.items.price + calcAddonPrice(cartpk.item_addons) | currency }}</b><br />
                        <a class="" @click.prevent="cartpk.shownRemoveAlert = !cartpk.shownRemoveAlert"><i class="fa fa-times" aria-hidden="true"></i> הסר</a>
                        <div v-show="cartpk.shownRemoveAlert">
                            <span>בטוח?</span>
                            <a class="alert label pointer" @click.prevent="removepk(cartpk.id)">כן</a>
                            <a class="secondary label pointer" @click.prevent="cartpk.shownRemoveAlert = false">לא</a>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="cart-ordersum-pod" v-if="!emptycart">
                <div class="cart-ordersum-bg">
                    <div class="sum-title">
                        סיכום הזמנה
                    </div>

                    <div class="subtotal-wrapper">
                        <span class="subtotal-label">סה"כ</span>
                        <span class="subtotal-value">{{ subtotal | currency }}</span>

                        <span class="subtotal-label">מע"מ</span>
                        <span class="subtotal-value">{{ tax | currency }}</span>

                        <hr>

                        <span class="subtotal-label">סה"כ כולל</span><br />
                        <span class="total-value">{{ total | currency }}</span>
                        <hr>

                        <div class="text-left">
                            <a class="button cart-btn-action" @click.prevent="payment()">לתשלום <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import spinner from "../shared/spinner.vue";
import selectPackDomain from "./selectPackDomain.vue";
import { cartStore } from "../../stores";
import { currency } from "../../utils";

export default {
  components: {
    spinner,
    selectPackDomain
  },

  filters: { currency },

  data() {
    return {
      loading: false,
      emptycart: true,
      subtotal: 0,
      total: 0,
      tax: 0,
      cartPackages: [],
      isUserConnected: false
    };
  },

  created() {
    this.loading = true;

    cartStore
      .isUserConnected()
      .then(data => {
        if (data == 0) {
          this.isUserConnected = false;
        } else {
          this.isUserConnected = true;
        }
      })
      .catch(err => {
        console.log(err);
      });

    cartStore
      .getAll()
      .then(data => {
        this.loading = false;

        data.length ? (this.emptycart = false) : (this.emptycart = true);

        $.each(data, index => {
          data[index].shownRemoveAlert = false;
        });

        this.cartPackages = data;
        this.total = this.calcTotal(this.cartPackages);
        this.tax = this.calcTax(this.total);
        this.subtotal = this.total - this.tax;
      })
      .catch(err => {
        this.loading = false;
        return err;
      });
  },

  methods: {
    removepk(id) {
      this.loading = true;

      let theindexis = _.findIndex(this.cartPackages, function(o) {
        return o.id === id;
      });

      cartStore
        .remove(id)
        .then(data => {
          this.loading = false;
          this.cartPackages.splice(theindexis, 1);
          this.total = this.calcTotal(this.cartPackages);
          this.tax = this.calcTax(this.total);
          this.subtotal = this.total - this.tax;
          this.cartPackages.length === 0 ? (this.emptycart = true) : null;
        })
        .catch(err => {
          console.log(3);
          this.loading = false;
        });
    },

    calcTax(total) {
      let taxvalue = 17;
      return (total / 100) * taxvalue;
    },

    calcTotal(data) {
      let total = 0;
      $.each(data, function() {
        total += this.items.price;
      });
      $.each(data, function() {
        $.each(this.item_addons, function() {
          if (this.id.includes("BT")) {
            total += this.pivot.total_hours * this.pivot.value * this.price;
          } else {
            total += this.price * this.pivot.value;
          }
        });
      });
      return total;
    },

    calcAddonPrice(data) {
      let total = 0;
      _.forEach(data, value => {
        if (value.id.includes("BT")) {
          total += value.price * value.pivot.value * value.pivot.total_hours;
        } else {
          total += value.price * value.pivot.value;
        }
      });
      return total;
    },

    wizard(id) {
      window.location.href = "/wizard?cart=" + id;
    },

    payment() {
      let _this = this;
      let domainMissing = false;

      if (!this.isUserConnected) {
        swal({
          title: "עליך להיכנס לחשבונך כדי להמשיך",
          html:
            'אם אין ברשותך חשבון עליך <a style="text-decoration:underline" href="/register">לפתוח חשבון חדש</a><br>אל דאגה כל הנתונים שהזנת נשמרו במערכת.',
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "כניסה לחשבון",
          cancelButtonText: "ביטול"
        }).then(() => {
          window.location.href = "/login";
        });
      } else {
        $.each(this.cartPackages, i => {
          if (this.cartPackages[i].domain) {
            if (
              this.cartPackages[i].domain.length < 4 ||
              this.cartPackages[i].errorCheckDomainAvaliable
            ) {
              _this.loading = false;
              domainMissing = true;
              swal({
                title: "לא הוגדרה כתובת דומיין חוקית",
                text:
                  "נא הגדר דומיין לחבילה " +
                  this.cartPackages[i].items.foreign_name,
                type: "warning"
              }).then(() => {});
            }
          } else {
            _this.loading = false;
            domainMissing = true;
            swal({
              title: "לא הוגדרה כתובת דומיין חוקית",
              text:
                "נא הגדר דומיין לחבילה " +
                this.cartPackages[i].items.foreign_name,
              type: "warning"
            }).then(() => {});
          }
        });

        if (!domainMissing) {
          window.location.href = "/payment";
        }
      }
    }
  }
};
</script>

<style lang="scss">
@import "../../../sass/partials/_vars.scss";

.small-link {
  font-weight: 400;
  text-decoration: underline;
  color: #555;
}

.empty-heading {
  font-weight: 900;
  text-align: center;
  margin-bottom: 12px;
  font-size: 36px;
}

.cart-items {
  float: right;
  width: 70%;
  margin-bottom: 50px;
}

.cart-items {
  tr {
    border-bottom: 1px solid $colorGrey1;
  }
}

.cart-items {
  td {
    padding-bottom: 20px;
  }
}

.cart-ordersum-pod {
  float: left;
  width: 30%;
  padding-right: 30px;
  margin-bottom: 50px;
}

.cart-ordersum-bg {
  background-color: $colorGrey3;
  border-radius: 4px;
}

.sum-title {
  font-family: "Lato", Optima, Segoe, "Segoe UI", Candara, Calibri, Arial,
    sans-serif;
  border-radius: 5px 5px 0px 0px;
  background: $colorGrey8;
  padding: 5px 0;
  text-align: center;
  letter-spacing: 0.07em;
  color: $colorGrey4;
  font-weight: 300;
  font-size: 20px;
  // margin-bottom: 15px;
  position: relative;
}

.sum-title:aftesdsr {
  top: 100%;
  right: 50%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(101, 69, 76, 0);
  border-top-color: $colorGrey8;
  border-width: 8px;
  margin-right: -8px;
}

.cart-btn-action {
  color: $colorWhite;
  font-size: 16px;
  font-weight: 800;
  background: $colorGreen;
  padding: 19px 27px;
  border-radius: 3px;
  border: 5px solid $colorGreen4;

  &:hover {
    color: $colorWhite;
    background: $colorGreen4;
  }
}

.subtotal-wrapper {
  padding: 30px;
}

.subtotal-label {
  font-weight: normal;
  line-height: 1.45;
  font-size: 17px;
  width: 150px;
  display: inline-block;
}

.subtotal-value {
  font-weight: 900;
  font-size: 17px;
}

.total-value {
  font-weight: 900;
  font-size: 42px;
}

.alert-text {
  color: $colorRed1;
  text-decoration: underline;
  cursor: pointer;
}

.addon-details {
  border-bottom: 1px dotted #aaa;
}
</style>
