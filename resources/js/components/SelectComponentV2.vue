<template>
  <div>
  <multiselect v-model="value" 
    :options="options" 
    :multiple="false" 
    group-values="data" 
    group-label="level" 
    :group-select="false" 
    placeholder="Select Level" 
    track-by="name" 
    label="name"
    >
      <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
    </multiselect>
    <input type="hidden" name="office_id" :value="value.id">
    
  
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
  components: {
    Multiselect
  },
  props: ['name'],
  created(){
      axios.get('/usr/branches')
        .then(res=>{
          this.options=res.data
        })
  },
  data () {
    return {
        lists: null,
        options: [],
        value: []
    }
  },
  methods: {
  }
}

</script>
<style scoped>
    @import "~vue-multiselect/dist/vue-multiselect.min.css";
</style>

