<template>
<div>
    <selectize v-model="selected" :settings="settings"> <!-- settings is optional -->
    <option v-for="office in offices" :key="office.id" :value="office.id" > {{office.name}}</option>
    </selectize>
    <button class="btn btn-default" @click="search">Search</button>
    <input type="hidden" v-model="selected" name="office_id" required>
    <input type="text" class="form-control" v-model="query" @keyup.enter="fetchRecords">
    <table class="table table-striped" v-if="!hidden">
    <thead>
      <tr>
        <th>Client ID</th>
        <th>Name</th>
        <th>Branch</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    <tr v-for="client in clients" :key="client.id">
      <td v-text="client.client_id"></td>
      <td v-text="client.firstname"></td>
      <td v-text="client.office.name"></td>
      <td>Test</td>
    </tr>
    </tbody>
    </table>

    
    
</div>
</template>
<script>
import Selectize from 'vue2-selectize'
import Loading from 'vue-loading-overlay';


import 'vue-loading-overlay/dist/vue-loading.css';


Vue.use(Loading);


export default {
  components: {
    Selectize,
    Loading
  },
  mounted(){
    axios.get('/auth/structure') 
        .then(res=>{
            this.offices = res.data
            this.selected = res.data[0].id
    })
  },
//   props: ['office_id'],
  data() {
    return {
        settings: {
              sortField: 'text',
              maxItems: 1
        }, // https://github.com/selectize/selectize.js/blob/master/docs/usage.md
        selected: 1,
        offices: [],
        selected: null,
        clients: null,
        url:null,
        hidden: true,
        query: ""
      }
  },
  methods: {
      search(){
        this.url = '/get'+window.location.pathname+'?office_id='+this.selected
        let loader = this.$loading.show({
                  // Optional parameters
                  container: this.fullPage ? null : this.$refs.formContainer,
                  canCancel: true,
                  onCancel: this.onCancel,
                  loader: 'bars',
                  height: 128,
                  width: 128,
        });
        axios.get(this.url).then(res=>{
            this.clients = res.data
            this.hidden = true;
            if(this.clients.length > 0){
              this.hidden = false;
            }
            loader.hide();
        })
        
      }
  },

}
</script>
