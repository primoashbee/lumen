<template>
<div>
    <selectize v-model="selected" :settings="settings" class="form-control">
            <option v-for="list in lists" :key="list.id" :value="list.id"> {{ list.name }}</option>
    </selectize>
</div>
</template>

<script>
import Selectize from 'vue2-selectize'
export default {
    components: {
        Selectize
    },
    mounted(){
        axios.get('/usr/branches')
            .then(res=>{
                this.lists = res.data
            })
    },
    data(){
        return {
            settings: {
                sortField: 'text'
            },
            selected: null,
            lists: null
        }
    },
    methods: {
        toUpperCase: ($string)=>{
            return $string.toUpperCase();
        }
    }
    
}
</script>

<style scoped>
    @import "~selectize/dist/css/selectize.bootstrap3.css";
</style>