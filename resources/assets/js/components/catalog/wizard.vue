<template lang="html">
    <div>
        <div class="text-center">
            <spinner v-if="loading"></spinner>
        </div>

        <div class="row">
            <div class="sum-title">
                אשף ניהול הגדרות החבילה:
                {{ package.foreign_name }}
                {{ package.description }}
            </div>
        </div>

        <div class="row domain-wrapper" v-if="wizardType === 'VPS'">
            <label id="serverDiv" style="margin-bottom: 15px;">בחר מערכת הפעלה
                <div class="server-spacer"></div>
                <a class="host-radio-btn button secondary ip-host-btn" :class="{ success: VPSOSSelected === os }" v-for="os in oses" @click.prevent="VPSOSSelected = os;getVPSAddons()">
                    <i class="fa fa-circle-thin" aria-hidden="true" v-show="VPSOSSelected !== os"></i>
                    <i class="fa fa-check-circle" aria-hidden="true" v-show="VPSOSSelected === os"></i>
                    {{ os }}</a>
            </label>
        </div>

        <div class="row domain-wrapper" v-if="(wizardType === 'VPS' && VPSOSSelected) || (wizardType === 'Shared')">
            <label id="serverDiv" style="margin-bottom: 15px;">בחר שרת מארח
                <div class="server-spacer"></div>
                <a class="host-radio-btn ip-host-btn button secondary" :class="{ success: ipHostSelected === ip.U_NICKNAME }" v-for="ip in ipHost" @click.prevent="ipHostSelected = ip.U_NICKNAME">
                    <i class="fa fa-circle-thin" aria-hidden="true" v-show="ipHostSelected !== ip.U_NICKNAME"></i>
                    <i class="fa fa-check-circle" aria-hidden="true" v-show="ipHostSelected === ip.U_NICKNAME"></i>
                    {{ ip.U_NICKNAME }}<br />{{ ip.U_IP }}</a>
            </label>
        </div>

        <br />
        <br />

        <div class="row" v-if="(wizardType === 'VPS' && VPSOSSelected) || (wizardType === 'Shared')">
            <div class="select-addons-title">
                בחר תוספות לחבילה
            </div>
        </div>

        <div class="row" v-if="(wizardType === 'VPS' && VPSOSSelected) || (wizardType === 'Shared')">

            <div class="flex-adn-bullet-item-wrapper">
                <div class="adn-bullet-item" :class="{active: item.active}" v-for="item in items">
                    <div class="adn-title">
                        <b>{{ item.foreign_name }}</b><br />
                        <img class="addon-icon" :src="addonIcon(item)" />
                        {{ item.id }}<br />
                        {{ item.description }}
                    </div>
                    <div class="adn-sum-price">
                        <div class="adn-unit-price">
                            {{ item.price | currency }} ליח'
                        </div>
                        <div v-if="item.uom === '100'">
                            {{ (item.price * item.value) / 100 | currency }}
                        </div>
                        <div v-else>
                            {{ item.price * item.value | currency }}
                        </div>
                        <div>
                            <!-- <input v-model="item.active" true-value="1" false-value="0" type="checkbox" class="confirm-addon" checked="checked"/> -->
                            <label class="container">
                                <input v-model="item.active" true-value="1" false-value="0" type="checkbox" class="confirm-addon" checked="checked"/>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                    </div>
                    <div class="adn-slider">
                        <vue-slider v-model="item.value" v-bind="item.slidercog"></vue-slider>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="wizardType === 'VPS' && VPSOSSelected">
            <div class="select-addons-title">
                בחר תוספות זמניות לחבילה
            </div>
        </div>

        <div class="row" v-if="wizardType === 'VPS' && VPSOSSelected">
            <div class="flex-adn-bullet-item-wrapper">
                <div class="adn-bullet-item boost-item" :class="{active: item.value}" v-for="item in boostItems">
                    <div class="adn-title">
                        <div class="sm-lbl" style="top:-29px">
                            פריט:
                        </div>
                        <b>{{ item.foreign_name }}</b><br />
                        <img class="addon-icon" :src="addonIcon(item)" />
                        {{ item.id }}<br />
                        {{ item.description }}
                    </div>
                    <div class="adn-sum-price">
                        <div class="adn-unit-price">
                            סך הכל שעות {{ item.total_hours = calcTotalHours(item.endDate, item.endTime) }}<br />
                            כפול {{ item.price | microCurrency }} ליח'
                        </div>
                        {{ item.price * item.value * calcTotalHours(item.endDate, item.endTime) | currency }}
                    </div>
                    <div class="adn-slider-bt">
                        <vue-slider v-model="item.value" v-bind="item.slidercog"></vue-slider>
                    </div>
                    <div class="adn-end-date-bt">
                        <div class="end-date-input-wrapper">
                            <input class="end-date" type="date" :min="minEndDate" v-model="item.endDate" :disabled="!item.value"></input>
                            <select class="end-time" v-model="item.endTime" :disabled="!item.value">
                                <option v-for="h in hours" :value="h">{{ h }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <a href="https://icons8.com/icon/1349/Website">Website icon credits</a>
        </div>

        <div id="stkftr" class="sticky-footer dofixed" v-if="(VPSOSSelected && wizardType === 'VPS') || (wizardType === 'Shared')">
            <div class="row">
                <div class="total-label-w">
                    <span class="total-value">{{ total | currency }}</span>
                    <a class="button cart-btn-action mr20" @click.prevent="savePackage()">שמור <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                </div>
                <div class="subtotal-label-w">
                    סה"כ
                    {{ subtotal | currency }}<br />
                    מע"מ
                    {{ tax | currency }}
                </div>
                <div class="subtotal-label-w">
                    מחיר החבילה
                    {{ package.price | currency }}<br />
                    מחיר התוספות
                    {{ total - package.price | currency }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import spinner from "../shared/spinner.vue";
import vueSlider from "vue-slider-component";
import { wizardStore } from "../../stores";
import { currency, microCurrency } from "../../utils";
import moment from "moment";

export default {
  props: ["cartid", "min", "max", "interval", "default"],

  components: {
    spinner,
    vueSlider
  },

  filters: {
    currency,
    microCurrency
  },

  data() {
    return {
      loading: false,
      wizardType: "",
      emptycart: false,
      package: "",
      ipHost: [],
      ipHostSelected: "",
      oses: ["Linux", "Windows"],
      VPSOSSelected: "",
      items: [],
      boostItems: [],
      today: moment(),
      minEndDate: moment()
        .add(1, "days")
        .format("YYYY-MM-DD"),
      hours: this.getHours()
    };
  },

  computed: {
    total() {
      return (
        this.calcTotal(this.items) +
        this.calcTotalTr(this.boostItems) +
        this.package.price
      );
    },

    tax() {
      return this.calcTax(this.total);
    },

    subtotal() {
      return this.total - this.tax;
    }
  },

  created() {
    this.loading = true;
    wizardStore
      .getWizard(this.cartid)
      .then(data => {
        this.loading = false;
        this.package = data.package;
        this.ipHostSelected = data.ipHostSelected;
        this.VPSOSSelected = data.ipVpsOs;
        this.wizardType =
          data.package.id.indexOf("VPS") > -1 ? "VPS" : "Shared";

        if (this.wizardType === "Shared") {
          this.loading = true;
          wizardStore
            .getSharedAddons(data.package.id, this.cartid)
            .then(data => {
              this.loading = false;
              this.items = data.addons;
              this.ipHost = data.ipHostList;
            })
            .catch(err => {
              this.loading = false;
              return err;
            });
        }

        if (this.wizardType === "VPS" && this.VPSOSSelected) {
          this.getVPSAddons();
        }
      })
      .catch(err => {
        this.loading = false;
        return err;
      });

    $(document).on("change", ".confirm-addon", function() {
      switch ($(this).is(":checked")) {
        case false:
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .removeClass("active");
          break;
        case true:
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .addClass("active");
          break;
      }
    });

    // click card to switch item.

    // $(document).on("click", ".adn-bullet-item", function() {
    //   let active = $(this).hasClass("active");
    //   switch (active) {
    //     case true:
    //       $(this).removeClass("active");
    //       break;
    //     case false:
    //       $(this).addClass("active");
    //       break;
    //   }
    // });

    $(document).scroll(function() {
      if (
        $(document).scrollTop() + window.innerHeight <
        $("footer.footer-short").offset().top
      )
        $("#stkftr").addClass("dofixed");
      if (
        $("#stkftr").offset().top + $("#stkftr").height() >
        $("footer.footer-short").offset().top
      )
        $("#stkftr").removeClass("dofixed");
    });
  },

  methods: {
    addonIcon(item) {
      let path = "images/icons/wizard/";
      return path + item.id.split("-")[1] + ".png";
    },

    getHours() {
      let hours = [];
      for (let i = 0; i < 24; i++) {
        hours[i] = (i < 10 ? "0" : "") + i + ":00";
      }

      return hours;
    },

    calcTax(total) {
      let taxvalue = 17;
      return (total / 100) * taxvalue;
    },

    calcTotalHours(endDate, endTime) {
      let toEnd = "";
      if (endDate && endTime) {
        toEnd = endDate + " " + endTime + ":00";
      }

      return moment().diff(toEnd, "hours") * -1 || 0;
    },

    calcTotal(data) {
      let total = 0;
      _.forEach(data, value => {
        total += value.price * value.value * value.active;
      });
      console.log(total);
      return total;
    },

    calcTotalTr(data) {
      let total = 0;

      _.forEach(data, value => {
        total +=
          value.price *
          value.value *
          this.calcTotalHours(value.endDate, value.endTime);
      });

      return total;
    },

    savePackage() {
      if (!this.ipHostSelected) {
        $("html, body").animate(
          {
            scrollTop: $("#serverDiv").offset().top - 30 + "px"
          },
          "slow"
        );
        swal("נא לבחור שרת מארח", "על ידי לחיצה על השרת המבוקש", "warning");
        return;
      }

      this.loading = true;

      let requestdata = {
        packageId: this.cartid,
        addons: this.items,
        trAddons: this.boostItems,
        ipHostSelected: this.ipHostSelected,
        vpsOs: this.VPSOSSelected,
        total: this.total
      };

      wizardStore
        .savePackage(requestdata)
        .then(data => {
          this.loading = false;
          swal({
            title: "פרטי החבילה נשמרו בהצלחה",
            text: 'סכ"ה לתשלום לחבילה: ' + currency(this.total),
            type: "success",
            showCancelButton: true,
            confirmButtonText: "המשך לעגלה",
            cancelButtonText: "שנה תוספות לחבילה"
          }).then(() => {
            window.location.href = "/cart";
          });
        })
        .catch(err => {
          this.loading = false;
          return err;
        });
    },

    getVPSAddons() {
      this.loading = true;
      wizardStore
        .getVPSAddons(this.VPSOSSelected, this.cartid)
        .then(data => {
          this.loading = false;
          this.items = data.addons;
          this.boostItems = data.boostTemporaryAddons;
          this.ipHost = data.ipHostList;
        })
        .catch(err => {
          this.loading = false;
          return err;
        });
    }
  }
};
</script>

<style lang="scss">
@import "../../../sass/partials/_vars.scss";

.flex-adn-bullet-item-wrapper {
  display: -webkit-flex;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 50px;
}

.adn-bullet-item {
  text-align: right;
  color: $colorGrey8;
  font-size: 14px;
  font-weight: normal;
  flex-grow: 0;
  width: 32%;
  height: 175px;
  margin-bottom: 10px;
  border-radius: 3px;
  margin-left: 5px;
  margin-right: 5px;
  border: 3px solid $colorWhite;
  background-color: $colorGrey1;
  opacity: 0.55;
  -webkit-transition: 0.5s; /* Safari */
  transition: 0.5s;

  //   &:hover {
  //     background-color: $colorWhite;
  //     border: 3px solid $colorGrey1;
  //     opacity: 1;
  //   }

  &.active {
    background-color: $colorWhite;
    border: 3px solid $colorGrey1;
    opacity: 1;
  }

  &.boost-item {
    width: 48%;
    margin: 8px;

    .adn-slider-bt {
      width: 44%;
      margin-right: 20px;
      margin-left: 20px;
    }
  }
}

.addon-icon {
  float: right;
  margin: 3px;
}
// https://icons8.com/

.adn-title {
  width: 70%;
  display: inline-block;
  padding: 10px;
  height: 130px;
}

.adn-slider {
  width: 90%;
  margin: 0 auto;
}

.adn-slider-bt {
  width: 35%;
  display: inline-block;
  padding: 0;
  position: relative;
}

.adn-end-date-bt {
  width: 20%;
  display: inline-block;
  position: relative;
}

.adn-unit-price {
  font-size: 12px;
  text-decoration: underline;
  color: #637080;
}

.adn-sum-price {
  width: 30%;
  font-size: 20px;
  float: left;
  padding: 10px;
  text-align: center;
  color: #c66c66;
  text-align: left;
}

.vue-slider-piecewise-label {
  opacity: 0.3;
}

.sticky-footer {
  background: $colorGrey1;
  padding: 5px;
  width: 100%;
  text-align: left;
  border-top: solid 1px #dadada;
}

.dofixed {
  position: fixed;
  bottom: 0;
  z-index: 9999;
  -webkit-box-shadow: 0px -10px 20px 0px rgba(100, 100, 100, 0.2);
  -moz-box-shadow: 0px -10px 20px 0px rgba(100, 100, 100, 0.2);
  box-shadow: 0px -10px 20px 0px rgba(100, 100, 100, 0.2);
}

.subtotal-label-w {
  font-size: 13px;
  float: left;
  padding: 10px;
  padding-left: 30px;
}

.total-label-w {
  text-align: left;
  float: left;
}

.mr20 {
  margin-right: 30px;
}

#back-to-top {
  display: none !important;
}

.select-addons-title {
  font-size: 30px;
  text-decoration: underline;
  text-align: center;
}

.btn-strong {
  background-color: #ffae00;
  color: #5a5a5a;
  border: 3px solid #bf870f;
}

.green {
  color: $colorGreen;
}

.red {
  color: $colorRed1;
}

.host-radio-btn {
  font-size: 1em;
}

.server-spacer {
  display: inline-block;
  width: 227px;
}

.end-date {
  width: 160px !important;
  float: left;
}

.end-time {
  width: 80px;
  padding: 7px;
  height: 36px;
}

.sm-lbl {
  position: absolute;
  top: -60px;
  font-size: 14px;
  color: #333;
  padding: 5px;
  background-color: $colorGrey6;
  border-radius: 3px 3px 0 0;
}

.end-date-input-wrapper {
  position: absolute;
  top: -44px;
  width: 250px;
  input,
  select {
    border: 2px solid $colorGreen6;
    height: 41px;
  }
}

.ip-host-btn {
  display: block;
  width: 200px;
  float: left;
  margin: 3px;
  font-size: 14px;
}

.domain-wrapper {
  background-color: $colorGrey3;
  border-bottom: solid 1px $colorGrey7;
  position: relative;
}

.domain-wrapper label {
  font-size: 30px;
  margin: 30px;
  color: #666;
}

/* Customize the label (the container) */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #ffffff;
  border: 1px solid #2196f3;
  border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196f3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
