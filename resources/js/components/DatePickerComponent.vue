<template>
    <datepicker @input="emitToParent" v-model="date" input-class="form-control" :value="value"  :format="format"></datepicker>

</template>


<script>

import Datepicker from 'vuejs-datepicker';
export default {
  components: {
    Datepicker
  },
  props: ['name','id','value'],
  methods:{
      emitToParent(){
          this.$emit('datePicked', this.date)
      }
  },
  data(){
      return {
          format: 'MMMM dd, yyyy',
          date: null,
      }
  },

}

</script>

<style>
    .form-control:disabled, .form-control[readonly]{
        background-color: transparent;
    }

    .is-invalid {
        border-color: red;
    }
 
</style>