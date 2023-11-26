<template>
    <div>
        <h2> Organism list ({{ organisms.length }}) </h2>

        <div v-if="organisms.length >1">
            <ul v-for="organism in organisms" :key="organism.id">
                <Organism_item :organism="organism"></Organism_item>
            </ul>
        </div>

        <p v-else>No organisms available.</p>

        <div v-if="meta && meta.last_page > 1">
            <button @click="loadOrganisms(meta.current_page - 1)" :disabled="meta.current_page === 1">Previous</button>
            <span>Page {{ meta.current_page }} of {{ meta.last_page }}</span>
            <button @click="loadOrganisms(meta.current_page + 1)" :disabled="meta.current_page === meta.last_page">
                Next
            </button>
        </div>
    </div>
</template>


<style lang="scss" scoped>


</style>


<script lang="ts">

import {Component, Vue} from 'vue-property-decorator';
import axios, {AxiosResponse} from 'axios';
import Organism_item from "./organism_item.vue";
import eventBus from '../event-bus';

interface Organism {
    id: number;
    genus: string;
    species: string;
}

interface PaginatedResponse {
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
    data: Organism[];
}

@Component({
    components: {
        Organism_item
    }
})
export default class OrganismsVue extends Vue {
    organisms: Organism[] = [];
    meta: { current_page: number; last_page: number; total: number; per_page: number } = {
        current_page: 1,
        last_page: 1,
        total: 0,
        per_page: 10,
    };

    mounted() {
        this.loadOrganisms();
        eventBus.$on('organismCreated', this.handleOrganismCreated);
    }

    beforeDestroy() {
        eventBus.$off('organismCreated', this.handleOrganismCreated);
    }

    handleOrganismCreated() {
        this.loadOrganisms(this.meta.current_page)
    }

    async loadOrganisms(page = 1) {
        try {
            const response: AxiosResponse<PaginatedResponse> = await axios.get(`/api/organisms?page=${page}`);
            this.organisms = response.data.data;
            this.meta = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                total: response.data.total,
                per_page: response.data.per_page,
            };
        } catch (error) {
            console.error('Error loading organisms:', error);
        }
    }
}
</script>
