<template>
    <main class="main">
        <v-container >
            <v-row justify="center">
                <v-col
                    cols="12"
                    sm="8"
                >
                    <v-card flat title="Notificator configuration">
                        <v-card-text>
                            <v-switch
                            v-model="hasActiveNotifications"
                            label="SMS Notifications"
                            color="info"
                            hide-details
                            :loading="isPending.hasActiveNotifications"
                            inset
                            @change="onChange"
                            ></v-switch>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="8">
                    <v-card flat title="Actual currency data">
                        <v-card-text>
                            <v-select
                            label="Currency"
                            v-model="latestCurrency"
                            :items="['USD', 'EUR', 'GBP']"
                            hide-details
                            class="mb-4"
                            ></v-select>
                            <v-btn  color="info" block size="x-large" @click="checkLastestRate" :loading="isPending.latestCurrency">
                                Check latest rate
                            </v-btn>
                            <v-snackbar
                            v-model="snackbar"
                            color="info"
                            vertical
                            >
                                <h3>Latest value: {{latestExchangeRate}} {{latestCurrency}}</h3>

                                <template v-slot:actions>
                                    <v-btn
                                    color="indigo"
                                    variant="text"
                                    @click="snackbar = false"
                                    >
                                    Close
                                    </v-btn>
                                </template>
                            </v-snackbar>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="8">
                    <v-card flat title="Calculate currency exchange">
                        <v-card-text>
                            <v-text-field
                            hide-details
                            clearable
                            v-model="plnCurrency"
                            label="PLN"
                            ></v-text-field>
                            <v-select
                            class="my-4"
                            label="Currency"
                            v-model="selectedCurrencyToCalculate"
                            hide-details
                            :items="['USD', 'EUR', 'GBP']"
                            @update:modelValue="calculateExchangeRate"
                            ></v-select>
                            <div class="mb-5 mt-10">
                                <h2 v-if="isPending.selectedCurrencyToCalculate">Loading...</h2>
                                <h2 v-else>Result PLN to {{selectedCurrencyToCalculate}} : {{exchangeResult}} PLN</h2>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </main>
</template>

<script>
import { ref, computed } from "vue";
import axios from 'axios';

export default ({
    setup() {
        const snackbar = ref(false);
        const item = ref(null);
        const isFetched = ref(false);
        const hasActiveNotifications = ref(false);
        const isPending = ref({
            hasActiveNotifications: false,
            latestCurrency: false,
            selectedCurrencyToCalculate: false
        });
        const latestCurrency = ref('USD');
        const selectedCurrencyToCalculate = ref('USD');
        const latestExchangeRate = ref(0);
        const plnCurrency = ref(0);

        const exchangeResult = computed(() => plnCurrency.value > 0 ? plnCurrency.value * latestExchangeRate.value : 0);

        const onChange = async() => {
            isPending.value.hasActiveNotifications = true;
            try{
                await axios.post(`http://127.0.0.1:8000/user-settings`, {
                hasActiveNotifications: Number(hasActiveNotifications.value),
                id: '636182a08392e0cb9f08b2b7'
            });
            isPending.value.hasActiveNotifications = false;
            }catch(error){
                console.log(error)
            }
        }

        const checkLastestRate = async() => {
            isPending.value.latestCurrency = true;
            try{
                const response = await axios.get(`/user-settings/latest-rate/${latestCurrency.value}`);
                latestExchangeRate.value = response.data;
                isPending.value.latestCurrency = false;
                snackbar.value = true;
            }catch(error){
                console.log(error)
            }
        }

        const calculateExchangeRate = async(isCalculating) => {
            isPending.value.selectedCurrencyToCalculate = true;
            try{
                const response = await axios.get(`/user-settings/latest-rate/${selectedCurrencyToCalculate.value}`);
                latestExchangeRate.value = response.data;
                isPending.value.selectedCurrencyToCalculate = false;
            }catch(error){
                console.log(error)
            }
        }

        axios.get(`/user-settings/636182a08392e0cb9f08b2b7`)
        .then(response => {
            item.value = response.data;
            isFetched.value = true;
            hasActiveNotifications.value = !!response.data?.hasActiveNotifications;
        })
        .catch(e => {
            console.log(e)
        })

        return {
            snackbar,
            isPending,
            onChange,
            item,
            isFetched,
            hasActiveNotifications,
            latestCurrency,
            latestExchangeRate,
            selectedCurrencyToCalculate,
            exchangeResult,
            plnCurrency,
            checkLastestRate,
            calculateExchangeRate
        }
    }
});
</script>
<style lang="scss">
.main{
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #d9eff3;
    height: 100vh;
    width: 100vw;
}
</style>
