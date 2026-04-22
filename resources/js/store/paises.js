import { defineStore } from 'pinia';
import { ref } from 'vue';
import usePaises from '../composables/paises';

export const useCountryStore = defineStore('countryStore', () => {
    const { getPaises } = usePaises();

    const countries = ref([]);

    async function fetchCountries() {
        getPaises()
            .then(response => {
                countries.value = response.data;
            })
            .catch(error => {
                console.error('Error fetching countries:', error);
            });
        return countries.value;
    }

    return { countries, fetchCountries };
}, { persist: true });
