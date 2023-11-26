<template>
    <li>{{ organism.id }} - {{ organism.genus }} - {{ organism.species }}</li>
</template>

<style lang="scss" scoped>
</style>

<script lang="ts">
import {Component, Prop, Vue} from "vue-property-decorator";
interface Organism {
    id: number;
    genus: string;
    species: string;
}

@Component({})
export default class OrganismVue extends Vue {
    @Prop({required: true, type: Object}) private organism!: Organism;
}
</script>
