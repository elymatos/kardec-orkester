<template>
    <div class="layout-main">
        <Card class="cardMargin">
            <template v-slot:title>
                <router-link to="/daisy">Daisy</router-link>
            </template>
            <template v-slot:content>
                Lu disambiguation
            </template>
        </Card>
        <Card class="cardMargin">
            <template v-slot:title>
                <router-link to="/carma">CARMA</router-link>
            </template>
            <template v-slot:content>
                Constructional Analysis
            </template>
        </Card>
        <Card class="cardMargin">
            <template v-slot:title>
                <router-link to="/arangodb">ArangoDb</router-link>
            </template>
            <template v-slot:content>
                ArangoDb Tests
            </template>
        </Card>
    </div>
</template>

<script>
export default {
    name: 'Main',
}
</script>
<style>
.cardMargin {
    margin-bottom:2rem;
}
</style>
