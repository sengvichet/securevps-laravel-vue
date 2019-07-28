<template>
    <div class="upgrade-wizard-container">
        <div class="upgrade-wizard-wrapper" v-bind:class="{
                        'upgrade-wizard-wrapper33': wizSteps[edStep].num === 3 && selectPackage === false,
                        'upgrade-wizard-wrapper3': wizSteps[edStep].num === 3 && selectPackage === true,
                        'upgrade-wizard-wrapper5': wizSteps[edStep].num === 5 && selectPackage === true,
                }">
            <button class="close-button" @click="closeUpgradeWizard()">
                <span aria-hidden="true">×</span>
            </button>

            <h3 class="upgrade-wizard-title">מספר הזמנה {{ order.Table.DocEntry }}</h3>

            <div class="modal-container modal-scrollbar"
                 v-bind:class="{
                        'modal-scrollbar2': wizSteps[edStep].num < 3,
                        'modal-scrollbar-height': wizSteps[edStep].num === 3 && selectPackage === false,
                        'modal-scrollbar-height3': wizSteps[edStep].num === 3 && selectPackage === true,
                        'modal-scrollbar-height5': wizSteps[edStep].num === 5 && selectPackage === true
                }"
            >
                <div class="change-order">
                    לשנות את ההזמנה (שינוי משאבים)
                </div>
                <div class="eo-q-w">
                    <b v-if="(wizSteps[edStep].num === 2 || wizSteps[edStep].num === 3) && (textHeader === 1 && addRemoveAddonsOnlyStep === false)" class="title-smaller">{{ wizSteps[edStep].title2 }}</b>
                    <b v-else-if="(wizSteps[edStep].num === 2 || wizSteps[edStep].num === 3) && (textHeader === 2 && addRemoveAddonsOnlyStep === false)" class="title-smaller">{{ wizSteps[edStep].title3 }}</b>
                    <b v-else-if="wizSteps[edStep].num === 2 && edStep === 1 && addRemoveAddonsOnlyStep === false" class="title-smaller">{{ wizSteps[edStep].title2 }}</b>
                    <b v-else>{{ wizSteps[edStep].title }}</b>
                    <div class="steps-indicator" v-if="this.activeDays !== 'false'">
                        שלב
                        {{ wizSteps[edStep].num }}
                        מתוך
                        5
                    </div>
                    <span v-if="wizSteps[edStep].num === 3  && (textHeader === 1 && addRemoveAddonsOnlyStep === false && order.Table1.length != undefined)"  class="current-package-term"><br />
תקופת החיוב הנוכחית להזמנה הינה <b>{{ currentPackageTerm }}</b> ולהלן האפשרויות לשינוי:
                    </span>
                </div>

                <div class="text-center" v-if="loadingUpgrade">
                    <spinner></spinner>
                </div>

                <div v-if="loading" class="text-center">
                    <spinner></spinner>
                    <div class="wait-loader">טוען, אנא המתן</div>
                </div>
                <div v-else>
                    <div v-if="order && order.Table1 && order.Table1.length != undefined">
                        <div :class="{ 'animated fadeInLeft': edStep === 0 }"  v-show="edStep === 0">
                            <a class="pop-action" @click="edStep = 1; addRemoveAddonsOnlyStep = false; stepOfStep = 1" >{{ stepOfStep1 }}. לשדרג לחבילה גדולה יותר או לעדכן אורך תקופת חיוב (חודשי/רבעוני/שנתי)</a><br />
                            <a class="pop-action" @click="edStep = 1; addRemoveAddonsOnlyStep = true; stepOfStep = 2">{{ stepOfStep2 }}. לשנות משאבים ספציפיים</a><br />
                            <a class="pop-action" @click="openPopUp()">{{ stepOfStep3 }}. שינמוך הזמנה</a>
                        </div>
                    </div>
                    <div v-else>
                        <div v-if="activeDays == 'true'">
                            <div :class="{ 'animated fadeInLeft': edStep === 0 }"  v-show="edStep === 0">
                                <a class="pop-action" @click="changePackageOnAddonStepForBackStep(1); stepOfStep = 1">{{ stepOfStep1 }}. לשדרג לחבילה גדולה יותר או לעדכן אורך תקופת חיוב (חודשי/רבעוני/שנתי)</a><br />
                                <a class="pop-action" @click="showPackage(1); stepOfStep = 2">{{ stepOfStep2 }}. לשנות משאבים ספציפיים</a><br />
                                <a class="pop-action" @click="edStep = 1; stepOfStep = 3">{{ stepOfStep3 }}. שינמוך הזמנה</a>
                            </div>
                        </div>
                        <div v-else>
                            <strong class="package-date-info">אין לך חבילה פעילה, אנא עדכן את תאריך החבילה שלך</strong>
                        </div>
                    </div>

                </div>


                <div :class="{ 'animated fadeInLeft': edStep === 1 }" v-show="edStep === 1" v-if="addRemoveAddonsOnlyStep === false">
                    <a class="pop-action" @click="getUpgradePackeges(1); textHeader = 1" >{{ stepOfStep1 }}.{{ stepOfStep }}. לעדכן את תקופת החיוב של האחסון ל-חודשי, רבעוני או שנתי</a><br />
                    <a class="pop-action" @click="getUpgradePackeges(2); textHeader = 2" >{{ stepOfStep2  }}.{{ stepOfStep }}. לשדרג את החבילה לחבילה עם משאבים רבים יותר</a><br />
                    <!--<a class="pop-action" @click="getUpgradePackeges(3)" v-if="this.order && this.order.Table1 && this.order.Table1.length != undefined">{{ stepOfStep3 }}.{{ stepOfStep }}. לשדרג את החבילה ליותר משאבים ולעדכן את תקופת החיוב של האחסון </a>-->
                </div>
                <div class="summerize-resources current-package-block" :class="{ 'animated fadeIn': selectedPackage.id }" v-if="currentPackageBlock === true && wizSteps[edStep].num === 3">
                    <table>
                        <tr class="trw">
                            <td colspan="5">
                                להלן המשאבים בחבילה הנוכחית שלך
                            </td>
                        </tr>

                        <tr class="bold">
                            <td>
                                סה"כ
                            </td>
                            <td>
                                Domain
                            </td>
                            <td>
                                HD Space
                            </td>
                            <td>
                                Bandwidth
                            </td>
                            <td>
                                Databases
                            </td>
                        </tr>
                        <tr  v-if="this.order && this.order.Table1 && this.order.Table1.length != undefined">
                            <td>
                                חבילה
                                {{ currentPackage.ItemCode }}
                            </td>
                            <td>
                                {{ currentPackageBlockItemprops['BasicDomain'] | quantity }}
                            </td>
                            <td>
                                {{ currentPackageBlockItemprops['BasicWebspace'] | disk }}
                            </td>
                            <td>
                                {{ currentPackageBlockItemprops['BasicBandwidth'] | disk }}
                            </td>
                            <td>
                                {{ currentPackageBlockItemprops['BasicDatabase'] | quantity }}
                            </td>
                        </tr>
                        <tr class="bold" v-if="changePackageOnAddonStep === false">
                            <td>
                                סה"כ
                            </td>
                            <td>
                                {{ sumCurrentDomains | quantity }}
                                <br />
                                Domain
                            </td>
                            <td>
                                {{ sumCurrentWebspace | disk }}
                                <br />
                                HD Space
                            </td>
                            <td>
                                {{ sumCurrentBandwidth | disk }}
                                <br />
                                Bandwidth
                            </td>
                            <td>
                                {{ sumCurrentDatabase | quantity }}
                                <br />
                                Databases
                            </td>
                        </tr>

                    </table>
                </div>

                <div :class="{ 'animated fadeInLeft': edStep === 2 }" v-show="edStep === 2">


                    <table :class="{ 'animated fadeIn': upgradePackages.length > 0 }" class="table-childrow" v-if="this.modalStep != 'Addon'">
                        <tr class="trw" v-if="currentPackageBlock === true && wizSteps[edStep].num === 3">
                            <td colspan="7">
                                חבילות אפשריות לשידרוג
                            </td>
                        </tr>
                        <tr class="bold">
                            <td colspan="2">
                                סה"כ
                            </td>
                            <td>
                                <br />
                                <!--דומיינים-->
                                Domain
                            </td>
                            <td>
                                <br />
                                <!--נפח דיסק-->
                                HD Space
                            </td>

                            <td>
                                <br />
                                <!--נפח תעבורה-->
                                Bandwidth
                            </td>
                            <td>
                                <br />
                                Databases
                            </td>
                            <td>
                                <br />
                                Price
                            </td>
                        </tr>

                        <tr class="markpink" v-for="item in upgradePackages" v-if="changePackageOnAddonStep === false">
                            <td class="radio-wrapper">
                                <i class="fa fa-circle-o fa-lg" aria-hidden="true" @click="selectPack(item.id)" v-show="selectedPackage.id !== item.id"></i>
                                <i class="fa fa-dot-circle-o gr fa-lg" aria-hidden="true" v-show="selectedPackage.id === item.id"></i>
                            </td>
                            <td>
                                {{ item.foreign_name }}<br />
                                {{ item.description }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['Z900-BasicDomain'] || 0) | quantity }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['Z901-BasicWebspace'] || 0) | disk }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['Z902-BasicBandwidth'] || 0) | disk }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['Z904-BasicDatabase'] || 0) | quantity }}
                            </td>
                            <td class="ltr">
                                {{ item.price | currency }}
                            </td>
                        </tr>


                        <tr class="markpink" v-for="item in upgradePackages" v-if="changePackageOnAddonStep === true">
                            <td class="radio-wrapper">
                                <i class="fa fa-circle-o fa-lg sel-1" aria-hidden="true" @click="selectPack(item.id, 1)" v-show="selectedPackage.id !== item.id"></i>
                                <i class="fa fa-dot-circle-o gr fa-lg" aria-hidden="true" v-show="selectedPackage.id === item.id"></i>
                            </td>
                            <td>
                                {{ item.foreign_name }}<br />
                                {{ item.description }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['BasicDomain'] || 0) | quantity }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['BasicWebspace'] || 0) | disk }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['BasicBandwidth'] || 0) | disk }}
                            </td>
                            <td>
                                {{ parseInt(item.itemprops['BasicDatabase'] || 0) | quantity }}
                            </td>
                            <td class="ltr">
                                {{ item.price | currency }}
                            </td>
                        </tr>
                    </table>

                    <table :class="{ 'animated fadeIn': upgradePackages.length > 0 }" class="table-childrow" v-else-if="changePackageOnAddonStep === false">
                        <tr class="markpink a-77" v-for="item in upgradePackages">
                            <td class="radio-wrapper">
                                <i class="fa fa-circle-o fa-lg" aria-hidden="true" @click="selectPack(item.id, upgradeTypeStep)" v-show="selectedPackage.id !== item.id"></i>
                                <i class="fa fa-dot-circle-o gr fa-lg" aria-hidden="true" v-show="selectedPackage.id === item.id"></i>
                            </td>
                            <td>
                                {{ item.foreign_name }}<br />
                                {{ item.description }}
                            </td>
                            <td class="slider-width" v-if="stepForAddonVersion == false">
                                <div class="flex-adn-bullet-item-wrapper2">
                                    <div class="adn-bullet-item2" :class="{active: item.value}">
                                        <div class="adn-slider2">
                                            <vue-slider v-model="item.value" v-bind="item.slidercog"></vue-slider>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="ltr">
                                {{ item.price | currency }}
                            </td>
                            <td class="ltr">
                                <div v-show="upgradeTypeStep == 2">
                                    <div v-if="item.uom === '100'">
                                        {{ (item.price * item.value) / 100 | currency }}
                                    </div>
                                    <div v-else>
                                        {{item.price * item.value | currency}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="summerize-resources" :class="{ 'animated fadeIn': selectedPackage.id }" v-if="selectedPackage.id">
                        <table>
                            <tr class="trw" v-show="currentPackageBlock === false">
                                <td colspan="5">
                                    <br />
                                    להלן המשאבים בחבילה הנוכחית שלך
                                </td>
                            </tr>

                            <tr class="bold" v-show="currentPackageBlock === false">
                                <td>
                                    סה"כ
                                </td>
                                <td>
                                   <!--דומיינים-->
                                    Domain
                                </td>
                                <td>
                                    <!--נפח דיסק-->
                                    HD Space
                                </td>
                                <td>
                                    <!--נפח תעבורה-->
                                    Bandwidth
                                </td>
                                <td>
                                    Databases
                                </td>
                            </tr>

                            <tr  v-if="this.order && this.order.Table1 && this.order.Table1.length != undefined" v-show="currentPackageBlock === false">
                                <td>
                                    חבילה
                                    {{ currentPackage.ItemCode }}
                                </td>
                                <td>
                                    {{ currentPackage.itemprops['Z900-BasicDomain'] | quantity }}
                                </td>
                                <td>
                                    {{ currentPackage.itemprops['Z901-BasicWebspace'] | disk }}
                                </td>
                                <td>
                                    {{ currentPackage.itemprops['Z902-BasicBandwidth'] | disk }}
                                </td>
                                <td>
                                    {{ currentPackage.itemprops['Z904-BasicDatabase'] | quantity }}
                                </td>
                            </tr>
                            <tr v-else>
                                <td>
                                    חבילה
                                    {{ packageItem.description }}
                                </td>
                                <td>
                                    {{ packageItem.itemprops.BasicDomain | quantity }}
                                </td>
                                <td>
                                    {{ packageItem.itemprops.BasicWebspace | disk }}
                                </td>
                                <td>
                                    {{ packageItem.itemprops.BasicBandwidth | disk }}
                                </td>
                                <td>
                                    {{ packageItem.itemprops.BasicDatabase | quantity }}
                                </td>
                            </tr>
                            <tr v-if="order && order.Table1 && order.Table1.length == undefined" v-for="addonData in activeAddonType">

                                <td class="act-add">
                                    {{ addonData.Addon.ItemCode }}
                                </td>
                                <td class="domain">
                                    {{ addonData.Addon.domain | quantity}}
                                </td>

                                <td class="webspace">
                                    {{ addonData.Addon.webspace }}
                                </td>

                                <td class="bandwidth">
                                    {{ addonData.Addon.bandwidth }}
                                </td>

                                <td class="databases">
                                    {{ addonData.Addon.database | quantity}}
                                </td>

                            </tr>

                            <tr v-else>
                                <td>
                                    תוספות
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0100-AddonDomain'] | quantity }}
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0101-AddonWebspace'] * 100 | disk }}
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0102-AddonBandwith'] * 1024 | disk }}
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0104-AddonDatabase'] | quantity }}
                                </td>
                            </tr>
                            <tr class="bold" v-if="changePackageOnAddonStep === false" v-show="currentPackageBlock === false">
                                <td>
                                    סה"כ
                                </td>
                                <td>
                                    {{ sumCurrentDomains | quantity }}
                                    <br />
                                    <!--דומיינים-->
                                    Domain
                                </td>
                                <td>
                                    {{ sumCurrentWebspace | disk }}
                                    <br />
                                    <!--נפח דיסק-->
                                    HD Space
                                </td>
                                <td>
                                    {{ sumCurrentBandwidth | disk }}
                                    <br />
                                    <!--נפח תעבורה-->
                                    Bandwidth
                                </td>
                                <td>
                                    {{ sumCurrentDatabase | quantity }}
                                    <br />
                                    Databases
                                </td>
                            </tr>
                            <tr class="bold" v-if="changePackageOnAddonStep === true">
                                <td>
                                    סה"כ
                                </td>
                                <td>
                                    {{ (parseInt(packageItem.itemprops.BasicDomain) + parseInt(sumDomainForTotal))  | quantity }}

                                    <br />
                                    <!--דומיינים-->
                                    Domain
                                </td>
                                <td>
                                    <!--{{ (parseFloat(packageItem.itemprops.BasicWebspace) + parseFloat(sumWebspaceForTotal)) | disk }}-->
                                    {{ packageItem.itemprops.BasicWebspace + sumWebspaceForTotal | disk }}

                                    <br />
                                    <!--נפח דיסק-->
                                    HD Space
                                </td>
                                <td>
                                    <!--{{ (parseFloat(packageItem.itemprops.BasicBandwidth) + parseFloat(sumBandwidthForTotal)) | disk }}-->
                                    {{ packageItem.itemprops.BasicBandwidth + sumBandwidthForTotal | disk }}

                                    <br />
                                    <!--נפח תעבורה-->
                                    Bandwidth
                                </td>
                                <td>
                                    {{ (parseInt(packageItem.itemprops.BasicDatabase) + parseInt(sumDatabaseForTotal)) | quantity }}

                                    <br />
                                    Databases
                                </td>
                            </tr>

                            <tr class="trw">
                                <td colspan="5">
                                    <br />
                                    לאחר השידרוג אלו יהיו המשאבים החדשים בחבילה שלך
                                </td>
                            </tr>
                            <tr v-if="order && order.Table1 && order.Table1.length !== undefined">
                                <td>
                                    חבילה
                                    {{ selectedPackage.id }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops['Z900-BasicDomain'] | quantity }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops['Z901-BasicWebspace'] | disk  }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops['Z902-BasicBandwidth'] | disk  }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops['Z904-BasicDatabase'] | quantity }}
                                </td>
                            </tr>
                            <!--<tr v-else>-->
                                <!--<td>-->
                                    <!--חבילה-->
                                    <!--{{ packageItem.description }}-->
                                <!--</td>-->
                                <!--<td>-->
                                    <!--{{ packageItem.itemprops.BasicDomain | quantity }}-->
                                <!--</td>-->
                                <!--<td>-->
                                    <!--{{ packageItem.itemprops.BasicWebspace | disk }}-->
                                <!--</td>-->
                                <!--<td>-->
                                    <!--{{ packageItem.itemprops.BasicBandwidth | disk }}-->
                                <!--</td>-->
                                <!--<td>-->
                                    <!--{{ packageItem.itemprops.BasicDatabase | quantity }}-->
                                <!--</td>-->
                            <!--</tr>-->

                            <tr v-if="order && order.Table1 && order.Table1.length == undefined && changePackageOnAddonStep === false">
                                <td>
                                    סך הכל
                                </td>
                                <td>
                                    {{ sumCurrentDomains | quantity }}
                                    <!--דומיינים-->
                                </td>
                                <td>
                                    {{ sumCurrentWebspace | disk }}
                                    <!--נפח דיסק-->
                                </td>
                                <td>
                                    {{ sumCurrentBandwidth | disk }}
                                    <!--נפח תעבורה-->
                                </td>
                                <td>
                                    {{ sumCurrentDatabase | quantity }}
                                </td>
                            </tr>

                            <tr v-if="order && order.Table1 && order.Table1.length !== undefined && changePackageOnAddonStep === false">
                                <td>
                                    תוספות
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0100-AddonDomain'] | quantity }}
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0101-AddonWebspace'] * 100 | disk }}
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0102-AddonBandwith'] * 1024 | disk }}
                                </td>
                                <td>
                                    {{ currentAddonsQuantity['AL0104-AddonDatabase'] | quantity }}
                                </td>
                            </tr>
                            <tr class="bottom-addon" v-else-if="order.Table1.length == undefined && changePackageOnAddonStep === false">
                                <td>
                                    {{ this.selectedNewAddon.description }}/תוספות
                                </td>
                                <td>
                                    {{ selectedAddonDomain | quantity }}
                                </td>
                                <td v-if="stepForWebspace === 2">
                                    {{ selectedAddonWebspace }}
                                </td>
                                <td v-else>
                                    {{ selectedAddonWebspace * 100 | disk }}
                                </td>
                                <td>
                                    {{ selectedAddonBandwidth | disk }}
                                </td>
                                <td>
                                    {{ selectedAddonDatabase | quantity }}
                                </td>
                            </tr>
                            <tr class="bold" v-if="changePackageOnAddonStep === false">
                                <td>
                                    סה"כ
                                </td>
                                <td>
                                    {{ sumSelectedDomains | quantity }}
                                    <br />
                                    <!--דומיינים-->
                                    Domain
                                </td>
                                <td>
                                    {{ sumSelectedWebspace | disk }}
                                    <br />
                                    <!--נפח דיסק-->
                                    HD Space
                                </td>

                                <td>
                                    {{ sumSelectedBandwidth | disk}}
                                    <br />
                                    <!--נפח תעבורה-->
                                    Bandwidth
                                </td>
                                <td>
                                    {{ sumSelectedDatabase | quantity }}
                                    <br />
                                    Databases
                                </td>
                            </tr>


                            <tr class="bold" v-if="changePackageOnAddonStep === true">
                                <td>
                                    סה"כ
                                </td>
                                <td>
                                    <!--דומיינים-->
                                    Domain
                                </td>
                                <td>
                                    <!--נפח דיסק-->
                                    HD Space
                                </td>
                                <td>
                                    <!--נפח תעבורה-->
                                    Bandwidth
                                </td>
                                <td>
                                    Databases
                                </td>
                            </tr>


                            <tr v-if="this.order && this.order.Table1 && this.order.Table1.length == undefined && changePackageOnAddonStep === true">
                                <td>
                                    <span class="bold">
                                    חבילה חדשה
                                     /</span>
                                    {{ selectedPackage.description }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops.BasicDomain | quantity }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops.BasicWebspace | disk }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops.BasicBandwidth | disk }}
                                </td>
                                <td>
                                    {{ selectedPackage.itemprops.BasicDatabase | quantity }}
                                </td>
                            </tr>
                            <tr v-if="order && order.Table1 && order.Table1.length == undefined && changePackageOnAddonStep === true" v-for="addonData in activeAddonType">

                                <td class="act-add">
                                    {{ addonData.Addon.ItemCode }}
                                </td>
                                <td class="domain">
                                    {{ addonData.Addon.domain | quantity}}
                                </td>

                                <td class="webspace">
                                    {{ addonData.Addon.webspace }}
                                </td>

                                <td class="bandwidth">
                                    {{ addonData.Addon.bandwidth }}
                                </td>

                                <td class="databases">
                                    {{ addonData.Addon.database | quantity}}
                                </td>

                            </tr>

                            <tr class="bold" v-if="changePackageOnAddonStep === true">
                                <td>
                                    סה"כ
                                </td>
                                <td>
                                    {{ sumCurrentDomains | quantity }}
                                    <br />
                                    <!--דומיינים-->
                                    Domain
                                </td>
                                <td>
                                    {{ sumCurrentWebspace | disk }}
                                    <br />
                                    <!--נפח דיסק-->
                                    HD Space
                                </td>
                                <td>
                                    {{ sumCurrentBandwidth | disk }}
                                    <br />
                                    <!--נפח תעבורה-->
                                    Bandwidth
                                </td>
                                <td>
                                    {{ sumCurrentDatabase | quantity }}
                                    <br />
                                    Databases
                                </td>
                            </tr>

                        </table>
                    </div>

                    <div class="text-center sum-total1" v-if="selectedPackage.id && this.order && this.order.Table1 && this.order.Table1.length != undefined">
                        <span v-if="annualSavePrice < 0">
                            <!--במעבר לחבילה זו אתה חוסך בשנה {{ annualSavePrice | currency }}-->
                            <!--<span>{{ annualSavePrice | currency }}</span>-->
                            <span>{{ selectedPackage.price | currency }} מחיר סופי</span>
                        </span>
                    </div>
                    <div class="text-center" v-else>
                        <span v-if="upgradeTypeStep == 1">
                            {{ selectedPackage.price | currency }} ר לחבילה זו אתה חוסך בשנה
                        </span>
                        <span v-else-if="changePackageOnAddonStep === true">
                            {{ selectedPackage.price | currency }} ר לחבילה זו אתה חוסך בשנה
                        </span>
                        <span class="left" v-else>
                            <!--{{ selectedPackage.value * selectedPackage.price | currency }} ר לחבילה זו אתה חוסך בשנה-->
                            <div class="markpink" v-for="(item, index ) in upgradePackages">
                                <div v-if="selectedTotalPrice(item, selectedPackage.id)">
                                     <div v-if="item.uom === '100'">
                                        {{ (item.price * item.value) / 100 | currency }} ר לחבילה זו אתה חוסך בשנה
                                    </div>
                                    <div v-else>
                                        {{ item.value * item.price | currency }} ר לחבילה זו אתה חוסך בשנה
                                    </div>
                                </div>
                            </div>
                        </span>
                    </div>

                    <div class="text-left">
                        <button type="button" v-if="changePackageOnAddonStep === false" :class="{disabled: !selectedPackage.id}" name="button" class="button" @click.prevent="setAddons()">הבא</button>
                        <button type="button" v-if="changePackageOnAddonStep === true" :class="{disabled: !selectedPackage.id}" name="button" class="button" @click.prevent="getUpgradeSummerize()">הבא</button>
                    </div>
                </div>

                <div :class="{ 'animated fadeInLeft': edStep === 3 }" v-show="edStep === 3">
                    <table :class="{ 'animated fadeIn': selectedAddons.length > 0 }" class="table-childrow">
                        <tr class="bold">
                            <td>
                                מס
                            </td>
                            <td>
                                תיאור/קוד פריט
                            </td>
                            <td>
                                כמות
                            </td>
                            <td>
                                מחיר ליח'
                            </td>
                            <td>
                                סה"כ
                            </td>
                        </tr>
                        <tr class="markpink a-1111" v-for="item in selectedAddons" v-if="modalStep != 'Addon'">
                            <td>
                                {{ item.LineNum }}
                            </td>
                            <td>

                                <span>{{ selectedPackage.description }}</span><br />
                                <span>{{ selectedPackage.id }}</span> <br />
                            </td>
                            <td>
                                <select v-model="item.Quantity">
                                    <option value="0">הסר</option>
                                    <option v-for="i in 10">{{ i }}</option>
                                </select>
                            </td>
                            <td class="ltr">
                                <!--{{ item.Price | currency }}-->
                                {{ selectedPackage.price | currency }}
                            </td>
                            <td class="ltr">
                                <!--{{ item.Price * item.Quantity | currency }}-->
                                {{ selectedPackage.price * item.Quantity | currency }}
                            </td>
                        </tr>
                        <tr class="markpink a-1010" v-else>
                            <td>1</td>
                            <td>
                                {{ selectedPackage.id }}<br />
                                {{ selectedPackage.description }}
                            </td>
                            <td>
                              <select v-model="selectedPackage.Quantity" v-on:change="addonLastPrice(selectedPackage.Quantity * selectedPackage.value * selectedPackage.price)">
                                <option value="0">הסר</option>
                                <option v-for="i in 10">{{ i }}</option>
                              </select>
                            </td>
                            <td class="selpack-1" v-if="selectedPackage.value !== undefined">
                                <!--{{ selectedPackage.value * selectedPackage.price | currency }}-->
                                {{ selectedPackageTotalPrice | currency }}
                            </td>
                            <td class="selpack-2" v-else>
                                {{ selectedPackage.price | currency }}
                            </td>

                            <td v-if="selectedPackage.value == undefined">
                                <div>
                                    {{ selectedPackage.Quantity * selectedPackage.price | currency }}
                                </div>
                            </td>
                            <td v-else>
                                <div>
                                    <div>{{ selectedPackageTotalPrice * selectedPackage.Quantity | currency}}</div>
                                    <!--{{ selectedPackage.Quantity * selectedPackage.value * selectedPackage.price | currency }}-->
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="text-left">
                        <button type="button" :class="{disabled: !selectedPackage.id}" name="button" class="button" @click.prevent="getUpgradeSummerize()">הבא</button>
                    </div>
                </div>

                <div :class="{ 'animated fadeIn': edStep === 4 }" v-if="edStep === 4">
                    שדרוג/שינוי פריטים עיקריים
                    <table class="table-childrow">
                        <tr class="bold">
                            <td>
                                פריט
                            </td>
                            <td>
                                תאריך התחלה
                            </td>
                            <td>
                                תאריך סיום
                            </td>
                            <td>
                                מחיר
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                שדרוג תוכנית והשלמת עלויות
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ currentPackage.ItemCode }}
                            </td>
                            <td>
                                {{ today | date }}
                            </td>
                            <td>
                                {{ endOfMonth | date }}
                            </td>
                            <td class="ltr">
                                {{ leftDaysToEndOfMonth * currentIdPayPerDay * -1 | currency }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ selectedPackage.id }}
                            </td>
                            <td>
                                {{ today | date }}
                            </td>
                            <td>
                                {{ endOfMonth | date }}
                            </td>
                            <td class="ltr">
                                {{ leftDaysToEndOfMonth * selectedIdPayPerDay | currency }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ selectedPackage.id }}
                            </td>
                            <td>
                                {{ nextMonth | date }}
                            </td>
                            <td>
                                {{ endSelectedPeriod | date }}
                            </td>
                            <td class="ltr">
                                {{ selectedPackage.price | currency }}
                            </td>
                        </tr>
                        <tr class="bold">
                            <td colspan="3">
                                סה"כ
                            </td>
                            <td class="ltr">
                                {{ total.package | currency }}
                            </td>
                        </tr>
                    </table>
                    <br />
                    זיכויים
                    <table class="table-childrow">
                        <tr class="bold">
                            <td>
                                פריט
                            </td>
                            <td>
                                תאריך סיום
                            </td>
                            <td>
                                מחיר ליום
                            </td>
                            <td>
                                ימים
                            </td>
                            <td>
                                כמות
                            </td>
                            <td>
                                מחיר
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                זיכוי עבור התוספות לחבילה הישנה
                            </td>
                        </tr>
                        <tr v-for="ref in refundAddons">
                            <td>
                                {{ ref.ItemCode }}
                            </td>
                            <td>
                                {{ ref.U_ICR_END_DATE | date }}
                            </td>
                            <td class="ltr">
                                {{ ref.pricePerDay | currency }}
                            </td>
                            <td>
                                {{ ref.leftDays | currency2 }}
                            </td>
                            <td>
                                {{ ref.Quantity | currency }}
                            </td>
                            <td class="ltr">
                                {{ ref.refund | currency }}
                            </td>
                        </tr>
                        <tr class="bold">
                            <td colspan="5">
                                סה"כ
                            </td>
                            <td class="ltr">
                                {{ total.refund | currency }}
                            </td>
                        </tr>
                    </table>
                    <br />
                    <span v-if="changePackageOnAddonStep === false">
                    חיובים
                    </span>
                    <table class="table-childrow" v-if="changePackageOnAddonStep === false">
                        <tr class="bold">
                            <td>
                                פריט
                            </td>
                            <td>
                                טווח תאריכים
                            </td>
                            <td>
                                מחיר ליום
                            </td>
                            <td>
                                ימים
                            </td>
                            <td>
                                כמות
                            </td>
                            <td>
                                מחיר
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                חישוב התוספות לחודש הנוכחי
                            </td>
                        </tr>
                        <tr v-for="n in chargeNewAddons.leftDaysThisMonth">
                            <td>
                                {{ n.foreign_name }}<br />
                                {{ n.ItemCode }}
                            </td>
                            <td class="ltr">
                                {{ n.pricePerDay | currency2 }}
                            </td>
                            <td>
                                {{ n.leftDays | currency }}
                            </td>
                            <td>
                                {{ n.Quantity | quantity2 }}
                            </td>
                            <td class="ltr">
                                {{ n.total | currency }}
                            </td>
                        </tr>
                        <tr class="bold">
                            <td colspan="5">
                                סה"כ
                            </td>
                            <td class="ltr">
                                {{ total.leftDaysThisMonth | currency }}
                            </td>
                        </tr>
                    </table>
                    <table class="table-childrow" v-if="changePackageOnAddonStep === true">
                        <tr>
                            <td class="bold" colspan="6">
                                Current Package Info
                            </td>
                        </tr>
                        <tr >
                            <td>
                            <span class="bold">Item</span>
                                <br />
                                <span>{{ packageItem.description }}</span>
                            </td>
                            <td>
                                <span class="bold">End Date - Start Date</span>
                                <br>
                                <span>{{ packageItem.U_ICR_START_DATE }}</span>
                                -
                                <span>{{ packageItem.U_ICR_END_DATE }}</span>
                            </td>
                            <td>
                                <span class="bold">Used Days</span>
                                <br>
                                {{ diffInDaysCurrentPackageNewPackageUsed }}
                            </td>
                            <td>
                                <span class="bold">Have Days</span>
                                <br>
                                {{ diffInDaysCurrentPackageNewPackageHave }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="bold">Price</span>
                                <br>
                            </td>
                            <td>
                                <span class="bold">Package Price</span>
                                <br>
                                <span class="ltr">{{ packageItem.price | currency }}</span>
                            </td>
                            <td>
                                <span class="bold">Was Spent</span>
                                <br>
                                    {{ wasSpentPriceCurrentPackage | currency }}
                            </td>
                            <td>
                                <span class="bold">Rest Balance</span>
                                <br>
                                    {{ restBalanceCurrentPackage | currency }}
                            </td>
                        </tr>

                    </table>
                    <br />
                    <table class="table-childrow" v-if="changePackageOnAddonStep === true">
                        <tr>
                            <td class="bold" colspan="6">
                                New Package Info
                            </td>
                        </tr>
                        <tr v-for="n in chargeNewAddons.period">
                            <td>
                                <br/>
                                <span class="bold">Item/</span><br />

                                {{ n.foreign_name }}<br />
                                {{ n.id }}<br />
                                {{ n.Dscription }}
                            </td>
                            <td>
                                <span class="bold">Period</span>
                                <br>
                               {{ n.startDate }}
                            </td>
                            <td>
                                <span class="bold">Active Days</span>
                                <br>
                                {{ diffInDaysCurrentPackageNewPackageUsed }}
                            </td>
                            <td>
                                <span class="bold">Daily Price</span>
                                <br>
                                {{ newPackagePricePerDay | currency }}
                            </td>
                            <td>
                                <span class="bold">Total Price</span>
                                <br>
                                {{ newPackageActiveDaysPrice | currency }}
                            </td>
                        </tr>
                        <tr v-if="restBalanceCurrentPackage != 0">
                            <td colspan="4">
                                <span>The residual of new Package price and rest balance</span>
                            </td>
                            <td>
                                {{ newPackageActiveDaysPrice | currency }} - {{ restBalanceCurrentPackage | currency }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                חישוב התוספות לפי התקופה המבוקשת
                            </td>
                            <td>
                                {{ newPackageActiveDaysPrice - restBalanceCurrentPackage | currency }}
                            </td>
                        </tr>
                    </table>
                    <table class="table-childrow" v-if="changePackageOnAddonStep === false">
                        <tr class="bold">
                            <td>
                                פריט
                            </td>
                            <td>
                                תאריך התחלה
                            </td>
                            <td>
                                תאריך סיום
                            </td>
                            <td>
                                כמות
                            </td>
                            <td>
                                מחיר
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                חישוב התוספות לפי התקופה המבוקשת
                            </td>
                        </tr>
                        <tr v-for="n in chargeNewAddons.period">
                            <td>
                                {{ n.foreign_name }}<br />
                                {{ n.ItemCode }}
                            </td>
                            <td>
                                {{ n.startDate | date }}
                            </td>
                            <td>
                                {{ n.endDate | date }}
                            </td>
                            <td>
                                {{ n.Quantity | quantity2 }}
                            </td>

                            <td class="ltr">
                                <!--{{ n.total |  currency }}-->
                                {{ total.period | currency}}
                            </td>
                        </tr>
                        <tr class="bold">
                            <td colspan="4" class="ltr">
                                סה"כ
                            </td>
                            <td class="ltr">
                                {{ total.period | currency }}
                            </td>
                        </tr>
                    </table>
                    <br />
                    סיכום פעילות
                    <table class="table-childrow">
                        <tr class="bold">
                            <td>
                                תיאור
                            </td>
                            <td>
                                חיוב/זיכוי
                            </td>
                            <td>
                                סה"כ
                            </td>
                        </tr>
                        <tr>
                            <td>
                                שדרוג חבילה
                            </td>
                            <td class="green">
                                חיוב
                            </td>
                            <td class="ltr">
                                {{ total.package | currency }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                זיכוי עבור התוספות לחבילה הישנה
                            </td>
                            <td class="red">
                                זיכוי
                            </td>
                            <td class="ltr">
                                {{ total.refund | currency }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                חישוב התוספות לחודש הנוכחי
                            </td>
                            <td class="green">
                                חיוב
                            </td>
                            <td class="ltr">
                                {{ total.leftDaysThisMonth | currency }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                חישוב התוספות לפי התקופה המבוקשת
                            </td>
                            <td class="green">
                                חיוב
                            </td>
                            <td class="ltr" v-if="changePackageOnAddonStep === false">
                                {{ total.period | currency }}
                            </td>
                            <td v-if="changePackageOnAddonStep === true">
                                {{ newPackageActiveDaysPrice - restBalanceCurrentPackage | currency }}
                            </td>
                        </tr>
                        <tr class="bold">
                            <td>
                                סה"כ
                            </td>
                            <td class="green">
                                חיוב
                            </td>
                            <td class="ltr">
                                {{ total.total | currency }}
                            </td>
                        </tr>
                    </table>
                    <br />
                    <a class="button large expanded" href="/payment" v-show="showPayButton">לחץ לתשלום</a>
                </div>
            </div>
                <div class="back-wrapper">
                    <a v-if="changePackageOnAddonStep === false" class="pop-back pop-back-position" @click="edStep--; back()" v-show="edStep > 0">
                        &#10141 חזור
                    </a>
                    <a v-if="changePackageOnAddonStep === true && edStep == 4" class="pop-back pop-back-position" @click="edStep = 2; back()">
                        &#10141 חזור
                    </a>
                    <a v-else-if="changePackageOnAddonStep === true && edStep == 2" class="pop-back pop-back-position" @click="edStep = 0; back()">
                        &#10141 חזור
                    </a>
                    <a v-else-if="changePackageOnAddonStep === true && edStep > 0" class="pop-back pop-back-position" @click="edStep--; back()">
                        &#10141 חזור
                    </a>
            </div>
        </div>
    </div>
</template>

<script>
import { date, currency, currency2, quantity, quantity2, intg, disk } from '../../utils'
import moment from 'moment'
import numeral from 'numeral'
import { userStore } from '../../stores'
import spinner from '../shared/spinner.vue'
import vueSlider from 'vue-slider-component/src/vue2-slider.vue'

export default {
    name: 'wizard--upgrade-order',

    components: {
        spinner,
        vueSlider
    },

    props: ['order'],

    data() {
        return {
            sliderValue2: 1,
            itemValue: 0,
            activeDays: '',
            currentPackage: '',
            currentAddons: '',
            edStep: 0,
            dayDiff: '',
            packageVersion: {},
            upgradePackages: [],
            upgradePackages2: [],
            showUpgrade: false,
            showUpgradeSummerize: false,
            today: moment(),
            endOfMonth: moment().endOf('month'),
            leftDaysToEndOfMonth: moment().endOf('month').diff(this.today, 'days'),
            loading: true,
            nextMonth: moment().endOf('month').add(1, 'days'),
            endSelectedPeriod: '',
            showPayButton: false,
            total: {},
            selectedPackage: [],
            selectedAddons: [],
            refundAddons: [],
            refundAddonsReq: {},
            chargeNewAddons: {},
            selectedAddonsQuantity: {},
            modalStep:'',
            selectedPrice: [],
            stepForAddonVersion: false,
            upgradeTypeStep: '',
            packageVersionAnnually: false,
            totalPriceForAddon: false,
            textHeader: 0,
            wizSteps: [
                {
                    step: 'first',
                    num: 1,
                    title: 'מה תרצה לעשות?'
                },
                {
                    step: 'upgradeType',
                    num: 2,
//                    title: 'מה תרצה לשדרג?'
                    title: 'הוספה/הסרה של תוספים בלבד',
                    title2: 'לשדרג לחבילה גדולה יותר או לעדכן אורך תקופת חיוב (חודשי/רבעוני/שנתי)'
                },
                {
                    step: 'selectPack',
                    num: 3,
                    title: 'בחר חבילה',
                    title2: 'לעדכן את תקופת החיוב של האחסון ל-חודשי, רבעוני או שנתי',
                    title3: 'לשדרג את החבילה לחבילה עם משאבים רבים יותר'
                },
                {
                    step: 'setAddons',
                    num: 4,
                    title: 'בחר תוספות לשינוי או הסרה'
                },
                {
                    step: 'summerize',
                    num: 5,
                    title: 'סיכום חשבון'
                }
            ],
            packageItem: [],
            activeAddonsforPackage: [],
            stepPackage: '',
            activeAddonType: [],
            sumDatabaseForTotal: 0,
            sumBandwidthForTotal: 0,
            sumWebspaceForTotal: 0,
            sumDomainForTotal: 0,
            selectedNewAddon: {},
            selectedAddonDatabase: 0,
            selectedAddonBandwidth: 0,
            selectedAddonWebspace: 0,
            selectedAddonDomain: 0,
            id3: '',
            selectedPackageTotalPrice: 0,
            addonSliderValue: 0,
            stepForWebspace: 0,
            versionAddon: null,
            changePackageOnAddonStep: false,
            domainForAddonVersionPackage: '',
            webSpaceForAddonVersionPackage: '',
            bandWidthForAddonVersionPackage: '',
            databaseForAddonVersionPackage: '',
            diffInDaysCurrentPackageNewPackageUsed: 0,
            diffInDaysCurrentPackageNewPackageHave: 0,
            wasSpentPriceCurrentPackage: 0,
            restBalanceCurrentPackage: 0,
            newPackageActiveDaysPrice: 0,
            newPackagePricePerDay: 0,
            addRemoveAddonsOnlyStep: false,
            stepOfStep: null,
            stepOfStep1: 1.1,
            stepOfStep2: 2.1,
            stepOfStep3: 3.1,
            currentPackageTerm: '',
            selectPackage: false,
            currentPackageBlock: false,
            currentPackageBlockItemprops: {},
        }
    },

    filters: {
        date,
        currency,
        currency2,
        quantity,
        quantity2,
        intg,
        disk,
    },

    created () {

        var versionAddon;

        if (this.order && this.order.Table1 && this.order.Table1.length != undefined) {

            let allCurrentItemsByFutureDate = this.order.Table1;
            versionAddon = 0;
            var dscription = '', searchResult = '';

            for (let element in allCurrentItemsByFutureDate) {

                dscription = allCurrentItemsByFutureDate[element].Dscription;
                searchResult = dscription.search(/Addon/);

                if (searchResult !== -1) {

                    versionAddon++;
                } else {

                    versionAddon = 0;
                    break;
                }
            };

            this.versionAddon = versionAddon;
        }


        if (this.order && this.order.Table1 && this.order.Table1.length != undefined && versionAddon == 0 ) {
//  Package version


            this.stepPackage == true;
            this.loading = false;


            let allCurrentItemsByFutureDate = _.uniqBy(_.filter(this.order.Table1, (pack) => {
                            return moment().diff(pack.U_ICR_END_DATE, 'days')
                        }), 'ItemCode')

            _.map(allCurrentItemsByFutureDate, (tag) => {
                    return tag.Quantity = parseInt(Math.floor(tag.Quantity))
                })

                this.currentPackage = _.filter(allCurrentItemsByFutureDate, (item) => {
                            return _.startsWith(item.Dscription, 'Package')
                        })[0]

                this.currentAddons = _.filter(allCurrentItemsByFutureDate, (item) => {
                            return _.startsWith(item.Dscription, 'Addon')
                        })
        } else {
            let allCurrentItemsByFutureDate = this.order.Table1;

            if (allCurrentItemsByFutureDate[0] && allCurrentItemsByFutureDate[0].Dscription ){

                var dscription = allCurrentItemsByFutureDate[0].Dscription;
            } else {
                var dscription = allCurrentItemsByFutureDate.Dscription;
            }


            var res = dscription.search(/Addon/);

            if (res >= 0) {
                userStore.checkAddonParentDate().then((data) => {

                    this.packageItem = data['data'][0];

                    if (data['data'] == -1) {
                        this.activeDays = 'false';
                    } else {
                        this.activeDays = 'true';
                    }

                    this.loading = false
               }).catch(error => {
                   this.loading = false
               })

                userStore.checkActiveAddon().then((data) => {

                    if (data['data'] == -1) {
                        this.activeAddonsforPackage = 'false';
                    } else {
                        this.activeAddonsforPackage = data['data'];


                        var valToArray = Object.values(this.activeAddonsforPackage);
                        var array = Object.values(valToArray);

                       var activeAddonType = [];

                       var sumDatabase = 0;
                       var sumBandwidth = 0;
                       var sumWebspace = 0;
                       var sumDomain = 0;

                       array.forEach(function(value, addonKey){

                          var addonDescription = value.Addon.Dscription;

                          var searchDatabaseResult = addonDescription.search(/Database/);
                          var searchBandwidthResult = addonDescription.search(/Bandwidth/);
                          var searchWebspaceResult = addonDescription.search(/Webspace/);
                          var searchDomainResult = addonDescription.search(/Domain/);

                            if (searchDatabaseResult !== -1) {

                                array[addonKey].Addon.database = value.Addon.Quantity;
                                array[addonKey].Addon.bandwidth = 0;
                                array[addonKey].Addon.webspace = 0;
                                array[addonKey].Addon.domain = 0;

                                sumDatabase += Number(value.Addon.Quantity);

                            } else if (searchBandwidthResult !== -1) {

                                array[addonKey].Addon.database = 0;

                                if (value.Addon.uom_type === 'MB') {
                                    array[addonKey].Addon.bandwidth = value.Addon.uom * value.Addon.Quantity / 1024 + ' GB';

                                    sumBandwidth += Number(value.Addon.uom * value.Addon.Quantity / 1024);
                                } else {
                                    array[addonKey].Addon.bandwidth = value.Addon.uom * value.Addon.Quantity + ' GB';

                                    sumBandwidth += Number(value.Addon.uom * value.Addon.Quantity);
                                }

                                array[addonKey].Addon.webspace = 0;
                                array[addonKey].Addon.domain = 0;

                            } else if (searchWebspaceResult !== -1) {

                                array[addonKey].Addon.database = 0;
                                array[addonKey].Addon.bandwidth = 0;

                                if (value.Addon.uom_type === 'MB') {
                                    array[addonKey].Addon.webspace = value.Addon.uom * value.Addon.Quantity / 1024 + ' GB';

                                    sumWebspace += Number(value.Addon.uom * value.Addon.Quantity / 1024);
                                } else {
                                    array[addonKey].Addon.webspace = value.Addon.uom * value.Addon.Quantity + ' GB';

                                    sumWebspace += Number(value.Addon.uom * value.Addon.Quantity);
                                }

                                array[addonKey].Addon.domain = 0;

                            } else if (searchDomainResult !== -1) {

                                array[addonKey].Addon.database = 0;
                                array[addonKey].Addon.bandwidth = 0;
                                array[addonKey].Addon.webspace = 0;
                                array[addonKey].Addon.domain = value.Addon.Quantity;

                                sumDomain += Number(value.Addon.Quantity);

                            } else {

                                array[addonKey].Addon.database = '0';
                                array[addonKey].Addon.bandwidth = '0';
                                array[addonKey].Addon.webspace = '0';
                                array[addonKey].Addon.domain = '0';

                            }
                        });

                        this.sumDatabaseForTotal = sumDatabase;
                        this.sumBandwidthForTotal = sumBandwidth;
                        this.sumWebspaceForTotal = sumWebspace;
                        this.sumDomainForTotal = sumDomain;

                        if (array) {
                            this.activeAddonType = array;
                        }

                    }
                }).catch(error => {
                   this.loading = false
               })
            }


            _.map(allCurrentItemsByFutureDate, (tag) => {
                    return 1
                })

                this.currentPackage = _.filter(allCurrentItemsByFutureDate, (item) => {
                            return _.startsWith(item.Dscription, ['Package'])
                })[0]

                this.currentAddons = allCurrentItemsByFutureDate

                this.packageVersion = this.currentAddons;
        }

            //    if(_.size(this.currentPackage) == 0 && _.size(this.currentAddons) == 0){
            //
            //
            //        let allCurrentItemsByFutureDate = this.order.Table1;
            //
            //        _.map(allCurrentItemsByFutureDate, (tag) => {
            //            return 1
            //        })
            //
            //        this.currentAnnualy = _.filter(allCurrentItemsByFutureDate, (item) => {
            //                    return _.startsWith(item.Dscription, ['Annualy'])
            //                })[0]
            //        this.currentAddons = allCurrentItemsByFutureDate
            //
            //    }

        let currentAddonsQuantity = []
        for(let item in this.currentAddons) {
                currentAddonsQuantity[this.currentAddons[item].ItemCode] = parseInt(this.currentAddons[item].Quantity)
            }

            this.currentAddonsQuantity = currentAddonsQuantity
    //      this.currentAddonsQuantity = this.currentAddons.ItemCode

            if(this.order && this.order.Table1 && this.order.Table1.length != undefined){
                this.selectedAddons = JSON.parse(JSON.stringify(this.currentAddons))
            }else{
                this.selectedAddons = 1
            }

    },

    computed: {
        sumCurrentDomains () {
            if (typeof this.currentPackage !== 'undefined' && this.currentPackage.itemprops) {

                return parseInt(this.currentPackage.itemprops['Z900-BasicDomain'] || 0) + parseInt(this.currentAddonsQuantity['AL0100-AddonDomain'] || 0)

            } else if (this.changePackageOnAddonStep === true) {

                var numDomains = numeral(this.selectedPackage.itemprops.BasicDomain).format('0,0')

                var parseDomainsPackage = parseInt(numDomains);

                let totalDomain = this.sumDomainForTotal + parseDomainsPackage;
                //this.domainForAddonVersionPackage = this.sumDomainForTotal + packageItem.itemprops.BasicBandwidth

                return totalDomain;

            } else if(this.currentPackageBlock === true) {
                return parseInt(this.currentPackageBlockItemprops['BasicDomain'] || 0) + parseInt(this.currentAddonsQuantity['AL0100-AddonDomain'] || 0)
            } else {

                var numDomains = numeral(this.packageItem.itemprops.BasicDomain).format('0,0')

                var parseDomainsPackage = parseInt(numDomains);

                let totalDomain = this.sumDomainForTotal + parseDomainsPackage;

                return totalDomain;

            }
        },

        sumCurrentWebspace () {
            if (typeof this.currentPackage !== 'undefined' && this.currentPackage.itemprops) {

                return parseInt(this.currentPackage.itemprops['Z901-BasicWebspace'] || 0) + parseInt((this.currentAddonsQuantity['AL0101-AddonWebspace'] || 0) * 100)

            } else if (this.changePackageOnAddonStep === true) {

                var parseWebspacePackage = this.selectedPackage.itemprops.BasicWebspace;

                let totalWebspace = this.sumWebspaceForTotal + (parseWebspacePackage / 1024);
//                this.webSpaceForAddonVersionPackage = this.sumWebspaceForTotal + packageItem.itemprops.BasicBandwidth

                return totalWebspace * 1024;

            } else if(this.currentPackageBlock === true) {
                return parseInt(this.currentPackageBlockItemprops['BasicWebspace'] || 0) + parseInt((this.currentAddonsQuantity['AL0101-AddonWebspace'] || 0) * 100)
            } else {

                var numWebspace = numeral(this.packageItem.itemprops.BasicWebspace).format('0,0')

                var parseWebspacePackage = parseInt(numWebspace);

                let totalWebspace = this.sumWebspaceForTotal + (parseWebspacePackage / 1024);

                return totalWebspace * 1024;

            }
        },

        sumCurrentBandwidth () {
            if (typeof this.currentPackage !== 'undefined' && this.currentPackage.itemprops) {

//              return parseInt(this.currentPackage.itemprops['Z902-BasicBandwidth'] || 0) + parseInt((this.currentAddonsQuantity['AL0102-AddonBandwith'] || 0) * 1024)
                return parseInt(this.currentPackage.itemprops['Z902-BasicBandwidth'] || 0)

            } else if (this.changePackageOnAddonStep === true) {

                var parseBandwidthPackage = this.selectedPackage.itemprops.BasicBandwidth / 1024;

                let totalBandwidth = this.sumBandwidthForTotal + parseBandwidthPackage;
//                this.bandWidthForAddonVersionPackage = this.sumBandwidthForTotal + packageItem.itemprops.BasicBandwidth

                return totalBandwidth * 1024;

            } else if(this.currentPackageBlock === true) {
                return parseInt(this.currentPackageBlockItemprops['BasicBandwidth'] || 0)
            } else {

                var numBandwidth = numeral(this.packageItem.itemprops.BasicBandwidth).format('0,0')

                var parseBandwidthPackage = parseInt(numBandwidth);

                let totalBandwidth = this.sumBandwidthForTotal + parseBandwidthPackage;

                return totalBandwidth * 1024;

            }
        },

        sumCurrentDatabase () {
            if (typeof this.currentPackage !== 'undefined' && this.currentPackage.itemprops) {

                return parseInt(this.currentPackage.itemprops['Z904-BasicDatabase'] || 0) + parseInt(this.currentAddonsQuantity['AL0104-AddonDatabase'] || 0)

            } else if (this.changePackageOnAddonStep === true) {

                var numDatabase = numeral(this.selectedPackage.itemprops.BasicDatabase).format('0,0')

                var parseDatabase = parseInt(numDatabase);

                let totalDatabases = this.sumDatabaseForTotal + parseDatabase;
//                this.databaseForAddonVersionPackage = this.sumDatabaseForTotal + packageItem.itemprops.BasicBandwidth

                return totalDatabases;

            } else if(this.currentPackageBlock === true) {
                return parseInt(this.currentPackageBlockItemprops['BasicDatabase'] || 0) + parseInt(this.currentAddonsQuantity['AL0104-AddonDatabase'] || 0)
            }  else {

                var numDatabase = numeral(this.packageItem.itemprops.BasicDatabase).format('0,0')

                var parseDatabase = parseInt(numDatabase);

                let totalDatabases = this.sumDatabaseForTotal + parseDatabase;

                return totalDatabases;

            }
        },

        sumSelectedDomains () {
            if(typeof this.currentPackage !== 'undefined'){
                return parseInt(this.selectedPackage.itemprops['Z900-BasicDomain'] || 0) + parseInt(this.currentAddonsQuantity['AL0100-AddonDomain'] || 0)
            }else{
                if(this.selectedPackage.description == 'Addon-Lx-Domain 1MB' || this.selectedPackage.description == 'Addon-Lx-Domain pointers'){
                    return (this.selectedPackage.value);
                }else{

                    return parseInt(this.sumCurrentDomains) + parseInt(this.selectedAddonDomain);

                }
            }
        },

        sumSelectedWebspace () {
            if(typeof this.currentPackage !== 'undefined'){
                return parseInt(this.selectedPackage.itemprops['Z901-BasicWebspace'] || 0) + parseInt((this.currentAddonsQuantity['AL0101-AddonWebspace'] || 0) * 100)
            }else{

                if(this.selectedPackage.description == 'Addon-Lx-Webspace 1MB'){
                    return (this.selectedPackage.uom);
                }else{

                    return parseInt(this.sumCurrentWebspace) + parseInt(this.selectedAddonWebspace);
                }
            }
        },

        sumSelectedBandwidth () {
            if(typeof this.currentPackage !== 'undefined'){
                return parseInt(this.selectedPackage.itemprops['Z902-BasicBandwidth'] || 0) + parseInt((this.currentAddonsQuantity['AL0102-AddonBandwith'] || 0) * 1024)
            }else{
                return parseInt(this.sumCurrentBandwidth) + parseInt(this.selectedAddonBandwidth);
            }
        },

        sumSelectedDatabase () {
            if(typeof this.currentPackage !== 'undefined'){
                return parseInt(this.selectedPackage.itemprops['Z904-BasicDatabase'] || 0) + parseInt(this.currentAddonsQuantity['AL0104-AddonDatabase'] || 0)
            }else{
                return parseInt(this.sumCurrentDatabase) + parseInt(this.selectedAddonDatabase);

            }
        },

        annualSavePrice () {
            if(typeof this.currentPackage !== 'undefined'){
                let spm = this.selectedPackage.price / this.selectedPackage.id.substring(0, 2)
                let cpm = this.currentPackage.Price / this.currentPackage.ItemCode.substring(0, 2)

                return (cpm * 12) - (spm * 12)
            }else{
                return 0;
            }
        },

        addonsQuantityToNumber () {
            var result = parseInt(this.currentAddons.Quantity);
            return result/1024;
        },
    },

    watch: {
        upgradePackages: {
            handler: function(newValue) {
                this.upgradePackages = newValue;
            },
            deep: true
        }
    },

    methods: {
        selectedTotalPrice(item, id){
            if(item.id == id){
//                this.selectedPackageTotalPrice = item.price * item.value

                    if (item.uom === '100' && item.uom_type === 'MB') {

                        this.selectedPackageTotalPrice = (item.price * item.value) / 100

                    } else {

                        this.selectedPackageTotalPrice = item.price * item.value
                    }

                this.addonSliderValue = item.value;
                this.stepForWebspace = 2;

                this.checkAdddonType(item, this.addonSliderValue, 2);

                return true;
            } else {

                return false;
            }
        },

        getUpgradePackeges (upgradeType) {

            if (this.selectedPackage.id) {
                this.selectPackage = true;
            } else {
                this.selectPackage = false;
            }
            this.upgradeTypeStep = upgradeType;

            if(upgradeType == 1){
                this.stepForAddonVersion = true;
                this.currentPackageBlock = false;
            } else if(upgradeType == 2){
                this.currentPackageBlock = true;
            }

            this.loadingUpgrade = true
            this.edStep = 2
            this.upgradePackages = []

            if(this.order && this.order.Table1 && this.order.Table1.length != undefined && this.versionAddon == 0){

                if (this.currentPackage.ItemCode.substring(0, 2) == '01') {
                    this.currentPackageTerm = 'חודשית'
                } else if (this.currentPackage.ItemCode.substring(0, 2) == '03') {
                    this.currentPackageTerm = 'רבעונית'
                } else {
                    this.currentPackageTerm = 'שנתית'
                }

              var res = 'pack';

              userStore.getUpgradePackeges(this.currentPackage.ItemCode, upgradeType, res).then((data) => {
                      this.loadingUpgrade = false

                  let indexOfCurrentPackage = _.findIndex(data, (o) => {
                      return o.id === this.currentPackage.ItemCode
                          })

                  this.currentPackage.itemprops = data[indexOfCurrentPackage].itemprops
                  this.currentPackageBlockItemprops = {
                    "BasicDomain": this.currentPackage.itemprops['Z900-BasicDomain'],
                    "BasicWebspace": this.currentPackage.itemprops['Z901-BasicWebspace'],
                    "BasicBandwidth": this.currentPackage.itemprops['Z902-BasicBandwidth'],
                    "BasicDatabase": this.currentPackage.itemprops['Z904-BasicDatabase']
                  };
                  data.splice(indexOfCurrentPackage,1)
                  this.upgradePackages = data
              }).catch(error => {
                    this.loadingUpgrade = false
            })
          }else{

              this.modalStep = 'Addon'

//            var addonType = this.order.Table1.ItemCode;

              var addonType = this.packageItem.id;

              var res = addonType.slice(0, 2);

              userStore.getUpgradePackeges(this.currentAddons.ItemCode, upgradeType, res).then((data) => {
                  this.loadingUpgrade = false

                  if (upgradeType == 1) {
//                        let result = data.splice(indexOfCurrentPackage, 1)
//
//                        this.upgradePackages = result

                          var element = false

                          data.forEach(function(addonInfo) {
                              let res2 = addonInfo.id.slice(2, 4);

                              if(res2 == res){

                                  element = addonInfo

                              }
                          })

                          if(element) {
                              this.upgradePackages = [element]

                              this.selectedNewAddon = element;

                              var selectedAddonDescription = element.description;

                            this.checkAdddonType(selectedAddonDescription, element, 1);

                          }

                  } else if(upgradeType == 2) {

                         this.upgradePackages = data

                  } else {
//                      Hold off on this for now

//                        userStore.getUpgradePackeges(this.currentAnnualy.ItemCode, upgradeType, res).then((data) => {
//                            this.loadingUpgrade = false
//
//                            let indexOfCurrentPackage = _.findIndex(data, (o) => {
//
//                                return o.id === this.currentAddons[0].ItemCode
//                            })
//
//                            this.currentAnnualy.itemprops = data[indexOfCurrentPackage].itemprops
//                            data.splice(indexOfCurrentPackage,1)
//
//                              this.upgradePackages = data
//
//                        }).catch(error => {
//                            this.loadingUpgrade = false
//                        })
                  }
              }).catch(error => {
                this.loadingUpgrade = false
            })
          }

            if(this.packageVersionAnnually == true){

             console.log('annualy');

            var addonType = this.order.Table1[0].ItemCode;
            var res = addonType.slice(2, 4);

        }
},

        selectPack (id, step = null) {

            this.selectPackage = true;
            if (step === 1) {

                 this.selectedPackage = this.upgradePackages[_.findIndex(this.upgradePackages, o => {

                     return o.id === id
                 })]

                 if (this.changePackageOnAddonStep === true) {

                     var startDateMoment = moment(this.packageItem.U_ICR_START_DATE);
                     var endDateMoment = moment(this.packageItem.U_ICR_END_DATE);
                     var currentMoment = moment();

                     this.diffInDaysCurrentPackageNewPackageUsed = currentMoment.diff(startDateMoment, 'days');
                     this.diffInDaysCurrentPackageNewPackageHave = endDateMoment.diff(currentMoment, 'days');

                     this.packageItem.U_ICR_END_DATE = endDateMoment.format('DD/MM/YYYY');
                     this.packageItem.U_ICR_START_DATE = startDateMoment.format('DD/MM/YYYY');

                     var pricePerDay = parseInt(this.packageItem.price) / (parseInt(this.packageItem.id.substring(0, 2)) * 30);
                     this.wasSpentPriceCurrentPackage = pricePerDay * this.diffInDaysCurrentPackageNewPackageUsed;
                     this.restBalanceCurrentPackage = this.packageItem.price - this.wasSpentPriceCurrentPackage;

                 }


             } else if (step === 2) {

                 var jsParse = JSON.parse(JSON.stringify(this.upgradePackages));

                 var valuesddds = Object.values([jsParse][0]);

                 this.selectedPackage = valuesddds[_.findIndex(valuesddds, o => {

                   return o.id === id
                 })]

             } else {

                 this.selectedPackage = this.upgradePackages[_.findIndex(this.upgradePackages, o => {

                     return o.id === id
                 })]
             }
        },

        addonLastPrice: function(price) {
            this.totalPriceForAddon = price
        },

        setAddons () {
            this.edStep = 3
        },

        getUpgradeSummerize() {
            this.loadingUpgrade = true
            this.edStep = 4

            var result = '';

            if (this.currentPackage && this.currentPackage != undefined) {
                this.loadingUpgrade = false

                var searchAddon = this.currentPackage.Dscription.search(/Addon/);

                  if (searchAddon !== -1) {
                      result = 'Addon';
                  }
            }

            if (this.currentPackage == undefined || result == 'Addon') {

//     Addon version

                this.currentPackage = this.currentAddons

                this.endSelectedPeriod = this.nextMonth.clone().add(this.selectedPackage.id.substring(0, 2), 'months').subtract(1, 'days')

                this.currentIdPayPerDay = (this.currentPackage.Price / moment().daysInMonth())
                this.selectedIdPayPerDay = (this.selectedPackage.price / moment().daysInMonth())
                this.total.package = (this.leftDaysToEndOfMonth * this.selectedIdPayPerDay) - (this.leftDaysToEndOfMonth * this.currentIdPayPerDay) + this.selectedPackage.price

                let refundAddons = []
                this.refundAddonsReq = {}

                let leftDays = -moment().diff(this.currentAddons.U_ICR_END_DATE, 'days')

                    let pricePerDay = parseInt(this.currentAddons.Price) / (parseInt(this.currentAddons.ItemCode.substring(2, 4)) * 30)

                    let quantity = parseInt(this.currentAddons.Quantity)

                    refundAddons.push({
                        Price: this.currentAddons.Price,
                        Quantity: quantity,
                        leftDays: leftDays,
                        ItemCode: this.currentAddons.ItemCode,
                        Dscription: this.currentAddons.Dscription,
                        U_ICR_END_DATE: this.currentAddons.U_ICR_END_DATE,
                        pricePerDay: pricePerDay,
                        refund: pricePerDay * leftDays * 1
                    })

                    this.refundAddonsReq[this.currentAddons.ItemCode] = quantity * -1

                this.refundAddons = refundAddons
                this.total.refund = _.sumBy(refundAddons, 'refund')

                userStore.getNewAddons(_.map(refundAddons, 'ItemCode'), this.selectedPackage.id).then((data) => {

                    let newAddons = [];
                    newAddons.push(this.selectedPackage)

                    let chargeNewAddons = {
                        leftDaysThisMonth: [],
                        period: [],
                    }

                    let period = this.selectedPackage.id.substring(0, 2)

                    this.selectedAddonsQuantity = {}

                    for (let i in this.selectedPackage) {

                        let newItemCode = period + this.selectedPackage.id.substring(2, 4) + this.selectedPackage.id.substring(4)

                        let row = _.filter(newAddons, (item) => {

                           return item.id.substring(0, 4) === newItemCode.substring(0, 4) && item.id.substring(6) === newItemCode.substring(6);
                        })

                        this.selectedAddonsQuantity[row[0].id] = this.selectedPackage.Quantity
                    }
                    var nextMonthDate = null;

                    for (let i in newAddons) {

                        var addonQtyInLastStep = null;

                        if (this.changePackageOnAddonStep === true) {
                            addonQtyInLastStep = 1;
                            this.selectedPackageTotalPrice = this.selectedPackage.price
                        } else {
                            addonQtyInLastStep = this.selectedAddonsQuantity[newAddons[i].id] || 0
                        }

                        let quantity = addonQtyInLastStep

                        let leftDays = parseInt(this.leftDaysToEndOfMonth)
                        let pricePerDay = parseInt(newAddons[i].price) / (parseInt(newAddons[i].id.substring(2, 4)) * 30)

                      //if (quantity > 0) {

                        chargeNewAddons.leftDaysThisMonth[i] = {
                            Price: newAddons[i].price,
                            Quantity: quantity,
                            leftDays: leftDays,
                            id: newAddons[i].id,
                            Dscription: newAddons[i].description,
                            foreign_name: newAddons[i].foreign_name,
                            startDate: this.today,
                            endDate: this.endOfMonth,
                            pricePerDay: pricePerDay,
                            total: pricePerDay * leftDays * quantity
                        }


                        if (this.changePackageOnAddonStep === false) {

                            nextMonthDate = this.nextMonth;
                        }

                        if (this.changePackageOnAddonStep === true) {

                            nextMonthDate = moment().format('MM/DD/YYYY');
                        }

                        chargeNewAddons.period[i] = {
                            Price: newAddons[i].price,
                            Quantity: quantity,
                            id: newAddons[i].id,
                            Dscription: newAddons[i].description,
                            foreign_name: newAddons[i].foreign_name,
                            startDate: nextMonthDate,
                            endDate: this.endSelectedPeriod,
                            total: newAddons[i].price * quantity
                        }

                        this.newPackagePricePerDay = parseInt(chargeNewAddons.period[i].Price) / (parseInt(chargeNewAddons.period[i].id.substring(0, 2)) * 30);
                        this.newPackageActiveDaysPrice = this.newPackagePricePerDay * this.diffInDaysCurrentPackageNewPackageUsed;
                        //}
                    }


                    this.chargeNewAddons = chargeNewAddons
                    this.total.leftDaysThisMonth = _.sumBy(chargeNewAddons.leftDaysThisMonth, 'total')

//                  var sumByTotalPrice = _.sumBy(chargeNewAddons.period, 'total')

//                  this.total.period = sumByTotalPrice/2 * 10

//                    this.total.period = _.sumBy(chargeNewAddons.period, 'total')

                    if (this.upgradeTypeStep == 1 && this.changePackageOnAddonStep === false) {

                        this.total.period = this.selectedPackage.price * this.selectedPackage.Quantity

                    } else if (this.changePackageOnAddonStep === true) {

                        this.total.period = this.selectedPackageTotalPrice

                    } else {

                        this.total.period = this.selectedPackageTotalPrice * this.selectedPackage.Quantity

                    }

                    if (this.changePackageOnAddonStep === true) {

                        this.total.total = this.total.package + this.total.leftDaysThisMonth + (this.newPackageActiveDaysPrice - this.restBalanceCurrentPackage) - this.total.refund

                    } else {

                        this.total.total = this.total.package + this.total.leftDaysThisMonth + this.total.period - this.total.refund

                    }


                     let params = {
                        orderId: this.order.Table.DocEntry,
                        total: this.total.total,
                        refundItems: JSON.stringify(this.refundAddonsReq),
                        items: JSON.stringify(this.selectedAddonsQuantity),
                        currentId: this.currentPackage.ItemCode,
                        selectedId: this.selectedPackage.id,
                        domain: this.order.Table.U_ICR_DOMAIN_NAME,
                        ipHost: this.order.Table1.U_ICR_IP,
                    }

                    userStore.setUpgradeSummerize(params).then((data) => {
                        this.loadingUpgrade = false
                        this.showPayButton = true
                    }).catch(error => {
                        this.loading = false
                    })

                }).catch(error => {
                    this.loadingUpgrade = false
                })
            } else {


//      Package version
                this.endSelectedPeriod = this.nextMonth.clone().add(this.selectedPackage.id.substring(0, 2), 'months').subtract(1, 'days')
                this.currentIdPayPerDay = (this.currentPackage.Price / moment().daysInMonth())
                this.selectedIdPayPerDay = (this.selectedPackage.price / moment().daysInMonth())
                this.total.package = (this.leftDaysToEndOfMonth * this.selectedIdPayPerDay) - (this.leftDaysToEndOfMonth * this.currentIdPayPerDay) + this.selectedPackage.price

                let refundAddons = []
                this.refundAddonsReq = {}
                for (let i in this.currentAddons) {

                    let leftDays = -moment().diff(this.currentAddons[i].U_ICR_END_DATE, 'days')

                    let pricePerDay = parseInt(this.currentAddons[i].Price) / (parseInt(this.currentAddons[i].ItemCode.substring(2, 4)) * 30)

                    let quantity = parseInt(this.currentAddons[i].Quantity)

                    refundAddons[i] = {
                        Price: this.currentAddons[i].Price,
                        Quantity: quantity,
                        leftDays: leftDays,
                        ItemCode: this.currentAddons[i].ItemCode,
                        Dscription: this.currentAddons[i].Dscription,
                        U_ICR_END_DATE: this.currentAddons[i].U_ICR_END_DATE,
                        pricePerDay: pricePerDay,
                        refund: pricePerDay * leftDays * quantity
                    }

                    this.refundAddonsReq[this.currentAddons[i].ItemCode] = quantity * -1
                }

                this.refundAddons = refundAddons
                this.total.refund = _.sumBy(refundAddons, 'refund')

                userStore.getNewAddons(_.map(refundAddons, 'ItemCode'), this.selectedPackage.id).then((data) => {
                    let newAddons = data
                    let chargeNewAddons = {
                        leftDaysThisMonth: [],
                        period: [],
                    }

                    let period = this.selectedPackage.id.substring(0, 2)
                    this.selectedAddonsQuantity = {}

                    for (let i in this.selectedAddons) {

                        let newItemCode = this.selectedAddons[i].ItemCode.substring(0, 2) + period + this.selectedAddons[i].ItemCode.substring(4)

//                    //_.find(newAddons, {id: newItemCode.substring(0, 4) + '__' + newItemCode.substring(6)}) ? this.selectedAddonsQuantity[newItemCode] = this.selectedAddons[i].Quantity : null

                        let row = _.filter(newAddons, (item) => {

                            return item.id.substring(0, 4) === newItemCode.substring(0, 4) && item.id.substring(6) === newItemCode.substring(6)
                        })

                        this.selectedAddonsQuantity[row[0].id] = this.selectedAddons[i].Quantity
                   }

                    var newPackage = [];
                    newPackage[0] = this.selectedPackage

                    for (let i in newPackage) {
//                    for (let i in newAddons) {

                        let quantity = this.selectedAddonsQuantity[newAddons[i].id] || 0
                        let leftDays = parseInt(this.leftDaysToEndOfMonth)
                        let pricePerDay = parseInt(newAddons[i].price) / (parseInt(newAddons[i].id.substring(2, 4)) * 30)

                        //if (quantity > 0) {

                         chargeNewAddons.leftDaysThisMonth[i] = {
                           Price: newPackage[i].price,
                            Quantity: quantity,
                            leftDays: leftDays,
                            ItemCode: newPackage[i].id,
                            Dscription: newPackage[i].description,
                            foreign_name: newPackage[i].foreign_name,
                            startDate: this.today,
                            endDate: this.endOfMonth,
                            pricePerDay: pricePerDay,
                            total: pricePerDay * leftDays * quantity
                        }

                         chargeNewAddons.period[i] = {
                             Price: newPackage[i].price,
                             Quantity: quantity,
                             ItemCode: newPackage[i].id,
                             Dscription: newPackage[i].description,
                             foreign_name: newPackage[i].foreign_name,
                             startDate: this.nextMonth,
                             endDate: this.endSelectedPeriod,
                             total: newPackage[i].price * quantity
                         }

                        //}
                    }

                    this.chargeNewAddons = chargeNewAddons
                    this.total.leftDaysThisMonth = _.sumBy(chargeNewAddons.leftDaysThisMonth, 'total')
                    this.total.period = _.sumBy(chargeNewAddons.period, 'total')
                    this.total.total = this.total.package + this.total.leftDaysThisMonth + this.total.period - this.total.refund

                    let params = {
                        orderId: this.order.Table.DocEntry,
                        total: this.total.total,
                        refundItems: JSON.stringify(this.refundAddonsReq),
                        items: JSON.stringify(this.selectedAddonsQuantity),
                        currentId: this.currentPackage.ItemCode,
                        selectedId: this.selectedPackage.id,
                        domain: this.order.Table.U_ICR_DOMAIN_NAME,
                        ipHost: this.order.Table1[0].U_ICR_IP,
                    }

                    userStore.setUpgradeSummerize(params).then((data) => {
                        this.loadingUpgrade = false
                        this.showPayButton = true
                    }).catch(error => {
                        this.loading = false
                    })

                }).catch(error => {
                    this.loadingUpgrade = false
                })
            }
        },

        closeUpgradeWizard () {
            this.$parent.showUpgradeWizard = false
        },

        checkAdddonType (selectedAddonDescription, element, funVersion) {

            if (funVersion === 2) {

                var item = selectedAddonDescription;
                selectedAddonDescription = selectedAddonDescription.description

            }

            var searchDatabasesAddon = selectedAddonDescription.search(/Database/);
            var searchBandwidthAddon = selectedAddonDescription.search(/Bandwidth/);
            var searchWebspaceAddon = selectedAddonDescription.search(/Webspace/);
            var searchDomainAddon = selectedAddonDescription.search(/Domain/);

            if (searchDatabasesAddon !== -1) {

                if (funVersion === 1) {

                    this.selectedAddonDatabase = element.Quantity;
                } else if(funVersion === 2) {

                    this.selectedAddonDatabase = element;
                }

                this.selectedAddonBandwidth = 0;
                this.selectedAddonWebspace = 0;
                this.selectedAddonDomain = 0;

            } else if (searchBandwidthAddon !== -1) {

                this.selectedAddonDatabase = 0;

                if (funVersion === 1) {

                    if (element.uom_type === 'MB') {

                        this.selectedAddonBandwidth = element.uom * element.Quantity / 1024 + ' GB';
                    } else {

                        this.selectedAddonBandwidth = element.uom * element.Quantity + ' GB';
                    }

                }  else if (funVersion === 2) {

                    if (item.uom_type === 'MB') {

                        this.selectedAddonBandwidth = element / 1024;
                    } else {

                        this.selectedAddonBandwidth = element * 1024;
                    }
                }

                this.selectedAddonWebspace = 0;
                this.selectedAddonDomain = 0;

            } else if (searchWebspaceAddon !== -1) {

                this.selectedAddonDatabase = 0;
                this.selectedAddonBandwidth = 0;

                if (funVersion === 1) {

                    if (element.uom_type === 'MB') {

                        this.selectedAddonWebspace = element.uom * element.Quantity / 1024 + ' GB';
                    } else {

                        this.selectedAddonWebspace = element.uom * element.Quantity + ' GB';
                    }

                } else if(funVersion === 2){

                    var webspaceCount = Math.round(element);

                    if (item.uom_type === 'MB') {

                        this.selectedAddonWebspace = (webspaceCount / 1024).toFixed(2)  + ' GB';
                    } else {

                        this.selectedAddonWebspace = webspaceCount.toFixed(2) + ' GB';
                    }
                }

                this.selectedAddonDomain = 0;

            } else if (searchDomainAddon !== -1) {

                this.selectedAddonDatabase = 0;
                this.selectedAddonBandwidth = 0;
                this.selectedAddonWebspace = 0;

                if (funVersion === 1) {

                    this.selectedAddonDomain = element.Quantity;
                } else if (funVersion === 2){

                    this.selectedAddonDomain = element;
                }

            } else {

                this.selectedAddonDatabase = '0';
                this.selectedAddonBandwidth = '0';
                this.selectedAddonWebspace = '0';
                this.selectedAddonDomain = '0';

            }

        },

        showPackage(){

            this.edStep = 2;
            var packageType = this.packageItem.id.substring(0, 2)
            var packageOs = this.packageItem.item_os
            var packageDn = this.packageItem.description
            this.changePackageOnAddonStep = true

            userStore.getAllPackeges(packageType, packageOs, packageDn).then((data) => {

                for (var i = 0; i < data.length; i++) {

                    if (data[i].price < this.packageItem.price) {
                        data.splice(i, 1);
                        i = i-1;
                    }

                }

                this.upgradePackages = data
                this.modalStep = ''

            }).catch(error => {
                this.loadingUpgrade = false
            })
        },

        changePackageOnAddonStepForBackStep(num){

            this.changePackageOnAddonStep = false

            this.edStep = num;
        },
        openPopUp() {
            swal({
                title: 'שינמוך הזמנה',
                text: 'על מנת לבצע שינמוך הזמנה, אנא צור קשר עם מרכז התמיכה באימייל:\n' +
                'hosting@shev.com\n' +
                'או בטלפון:\n' +
                '03-6421228',
                type: 'success',
                confirmButtonText: 'סגור'
            })
        },
        back() {
            document.getElementsByClassName('modal-scrollbar')[0].scrollTo(0, 0);
        }
    }
}
</script>

<style lang="scss">
@import "../../../sass/partials/_vars.scss";

td {
    .radio-wrapper {
        text-align: center;
    }
}

.sum-total {
    padding: 25px 5px 10px;
}

.summerize-resources {
    margin: 20px auto;
    font-size: 0.8em;
}

.trw {
    background-color: $colorWhite !important;
    font-size: 1.2em;
    font-weight: 700;
    border-bottom: 1px solid $colorBlack;
}

.close-popup {
    position: absolute;
    top: 13px;
    right: 17px;
}
.flex-adn-bullet-item-wrapper2 {
    display: -webkit-flex;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 13px;
    margin-top: 16px;
}

.adn-bullet-item2 {
    text-align: right;
    color: $colorGrey8;
    font-size: 14px;
    font-weight: normal;
    flex-grow: 0;
    width: 180px;
    /*height: 15px;*/
    border-radius: 3px;
    margin-left: 5px;
    margin-right: 5px;
    border: 3px solid $colorWhite;
    background-color: $colorGrey1;
    opacity: 0.55;
    -webkit-transition: 0.5s; /* Safari */
    transition: 0.5s;

    &:hover {
         background-color: $colorWhite;
         border: 3px solid $colorGrey1;
         opacity: 1;
     }

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
    .slider-width{
        width: 140px;
    }
    .pop-back-right{
        float: right;
    }
    .pop-back-position{
        padding-bottom: 40px;
    }
    .upgrade-wizard-container .change-order {
        text-align: left;
        font-size: 14px;
    }
    .upgrade-wizard-container .title-smaller {
        font-size: 17px;
    }
    .upgrade-wizard-container .modal-scrollbar2 {
        overflow-y: hidden;
    }
    .upgrade-wizard-container .current-package-term {
        font-size: 14px;
        display: inline-block;
    }
    .upgrade-wizard-container .modal-scrollbar {
        padding-bottom: 30px;
        min-height: 307px;
    }
    .upgrade-wizard-wrapper {
        min-height: 500px;
    }
    .upgrade-wizard-wrapper3 {
        max-height:calc(90vh);
    }
    .upgrade-wizard-wrapper33 {
        max-height: unset;
    }
    .upgrade-wizard-wrapper5 {
        max-height: 800px;
    }
    .upgrade-wizard-container .modal-scrollbar-height {
        max-height:unset;
    }
    .upgrade-wizard-container .modal-scrollbar-height3 {
        max-height: -webkit-fill-available;
        max-height: -moz-available;
        max-height: fill-available;
    }
    .upgrade-wizard-container .modal-scrollbar-height5 {
        max-height:683px;
    }
    .upgrade-wizard-container .back-wrapper {
        margin-top: 0;
        padding-right: 40px
    }
    .current-package-block {
        margin: 0;
    }
</style>
