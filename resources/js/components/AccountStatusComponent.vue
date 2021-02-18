<template>
  <div>
  <multiselect 
    v-model="value" 
    :options="options" 
    :multiple="_multiValues" 
    @input = "emitToParent"
    :clear-on-select="true"

    >
    <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
    </multiselect>
    <input type="hidden" name="status" id="status" :value="value" @change="emitToParent">
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
  components: {
    Multiselect
  },
  props: ['multi_values','add_class'],
  created(){

  },
  data () {
    return {
        lists: null,
        options: ["All","Active", "Cancelled", "Closed", "In Arrears", "Inactive", "Matured", "Pending Approval", "Rejected", "Written Off"],
        value: null
    }
  },
  methods: {
    emitToParent(){
      if(this.value!=null){
        
        this.$emit('statusSelected', this.value)
      }
    }
  },
  computed: {
    _multiValues(){
      if(this.multi_values != "true" || this.multi_values != "1"){
        return false;
      } 

      return true;
    }
  }
}
</script>
<style>
    @import "~vue-multiselect/dist/vue-multiselect.min.css";
    .multiselect__tags{
      background: #27293d;
    }
    .multiselect__input{
      background: #27293d!important;
      border-color:#2b3553
    }
    .multiselect__single{
      background: #27293d!important;
      color: white;
    }
    .is-invalid .multiselect__tags {
      border: 1px solid red !important;
    }

</style>

