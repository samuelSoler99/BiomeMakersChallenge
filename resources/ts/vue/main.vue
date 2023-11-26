<template>
    <div>
        <h1> BiomeMakers Challenge </h1>
        <ul>
            <li><a href="/api/samples">/api/samples</a></li>
            <li><a href="/api/organisms">/api/organisms</a></li>
            <li><a href="/api/organisms-top10">/api/organisms-top10</a></li>
        </ul>
        <div class="pure-g widgets">
            <div class="pure-u-1-3">
                <SamplesVue/>
            </div>
            <div class="pure-u-1-3">
                <NewOrganismVue/>
            </div>
            <div class="pure-u-1-3">
                <OrganismsVue/>
            </div>
        </div>
        <p> BiomeMakers Challenge </p>
    </div>
</template>

<style lang="scss" scoped>
.widgets > div > div {
    padding: 2em 1em 0;
}
</style>


<script lang="ts">
import {Vue, Component, Prop, Watch} from 'vue-property-decorator';
import SamplesVue from './samples.vue';
import NewOrganismVue from './new_organism.vue';
import OrganismsVue from './organisms.vue';

@Component({
    components: {
        SamplesVue,
        NewOrganismVue,
        OrganismsVue,
    }
})
export default class MainVue extends Vue {

}
</script>
