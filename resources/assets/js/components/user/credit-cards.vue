<template>
    <div class="row">
        <div>
            <div v-if="!loading">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-2 col-sm-7 col-sm-offset-5 col-md-5 col-md-offset-7">

                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">כרטיסי אשראי</div>

                            <!-- List group -->
                            <ul class="list-group mr0">
                                <li class="list-group-item" v-for="creditCard in creditCards">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-6 pr0">
                                            <p>{{ creditCard.CardLastDigits }}</p>
                                            <p>{{ creditCard.ExpirationDate }}</p>
                                            <p><a href="#" @click.prevent="removeCreditCard(creditCard)">הסרת כרטיס אשראי</a></p>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-5 pl0">
                                            <p>{{ creditCard.CardName }}</p>
                                            <p><img :src="getImagePathByCardName(creditCard.CardName)" alt="" class="card"></p>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-1">
                                            <input type="radio" name="default_credit_card" :checked="creditCard.IsCreditDefault == '1' ? 'checked' : ''" v-on:change="markCreditCardAsDefault(creditCard)">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
            <div class="text-center">
                <spinner v-if="loading"></spinner>
            </div>
        </div>
    </div>
</template>

<script>
import spinner from '../shared/spinner.vue'
import { userStore } from '../../stores'

export default {
    name: 'credit-cards',

    components: {
        spinner,
    },

    data () {
        return {
            loading: true,
            creditCards: [],
            defaultCreditCard: {}
        }
    },

    created () {
        userStore.getAllCreditCards().then(data => {
            this.loading = false
            this.creditCards = data.credit_cards

            for(let i=0; i< this.creditCards.length; i++) {
                if(this.creditCards[i].IsCreditDefault == '1') {

                    this.defaultCreditCard = this.creditCards[i];
                }
            }

            console.log(this.defaultCreditCard);

        }).catch(error => {
            this.loading = false
        });
    },

    methods: {
        update() {

        },

        getImagePathByCardName(cardName) {
            let path = '/images/cards/';
            let imageName = '';

            switch(cardName) {
                case 'ויזה כאל':
                    imageName = 'visa.png';
                    break;
                case 'ישראכרט-מאסטרקארד':
                    imageName = 'isra-card.png';
                    break;
                case 'אמריקן אקספרס':
                    imageName = 'amex.png';
                    break;
                case 'דיינרס קלאב':
                    imageName = 'diners-club.png';
                    break;
                case 'מאסטרקארד':
                    imageName = 'master-card.png';
                    break;
                default:
                    imageName = 'default.png';
            }

            let imageUrl = path + imageName;

            return imageUrl;
        },
        removeCreditCard(creditCard) {
            swal({
                title: 'הסרת כרטיס אשראי',
                html: 'האם אתה בטוח שברצונך להסיר את כרטיס האשראי?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'לְהַסִיר',
                cancelButtonText: 'ביטול',
            }).then(() => {
                userStore.removeCreditCard(creditCard).then(data => {
                    // Remove item from view
                    this.creditCards.forEach((element) => {
                        if(element.CardLastDigits === creditCard.CardLastDigits && element.CardName === creditCard.CardName &&  element.ExpirationDate === creditCard.ExpirationDate) {
                            let index = this.creditCards.indexOf(element);
                            this.creditCards.splice(index, 1);
                        }
                    })

                }).catch(error => {
                    console.log('error');
                });
            })
        },
        markCreditCardAsDefault(creditCard) {

            let oldCardNumber = this.defaultCreditCard.CardLastDigits ;
            let newCardNumber = creditCard.CardLastDigits;
            this.defaultCreditCard = creditCard;

            swal({
                title: 'שינוי ברירת מחדל לכרטיס אשרא',
                html: 'האם אתה רוצה לשנות את כרטיס ברירת המחדל מ'+oldCardNumber+' אל הכרטיס '+newCardNumber+'?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'לשנות?',
                cancelButtonText: 'ביטול',
            }).then(() => {
                userStore.markCreditCardAsDefault(creditCard).then(data => {
                    console.log('marked as default');
                }).catch(error => {
                    console.log('error');
                });
            })
        },
    }
}
</script>
