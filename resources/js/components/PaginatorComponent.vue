<template>
    <div>
        <nav aria-label="Page navigation example" v-if="shouldPaginate" >
        <ul class="pagination">
            <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous" @click.prevent="firstPage" style="color:black">
                <!-- <span aria-hidden="true">&laquo;</span> -->
                First
            </a>
            </li>
            <li class="page-item" v-show="prevUrl" >
            <a class="page-link" href="#" aria-label="Previous" @click.prevent="page--" style="color:black">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
            </li>
            <li class="page-item" v-for="page in pages" :key="page.id">
                <a class="page-link" style="color:black"  href="#" @click.prevent="changePage(page)">{{page}}</a>
            </li>
            <li class="page-item" v-show ="nextUrl">
            <a class="page-link" href="#" style="color:black"   aria-label="Next" @click.prevent="page++">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
            </li>
            <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous" @click.prevent="lastPage" style="color:black">
                <!-- <span aria-hidden="true">&raquo;</span> -->
                Last
            </a>
            </li>
        </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props : ['dataset'],
    data(){
        return {
            page: 1,
            prevUrl : false,
            nextUrl: false,
            page_count: 0,
            last_page: false,
            first_page: false
        }
    },
    methods: {
       broadcast(){
           this.$emit('updated',this.page)
       },
       changePage(page){
           this.page = page
       },
       lastPage(){
           this.page= this.last_page
       },
       firstPage(){
           this.page= this.first_page
       }
    },
    watch: {
        dataset: {
            immediate: true,
            handler(){
                this.page =this.dataset.current_page
                this.prevUrl =this.dataset.prev_page_url
                this.nextUrl =this.dataset.next_page_url
                this.page_count = this.dataset.last_page
                this.first_page = this.dataset.first_page
                this.last_page = this.dataset.last_page
            }
        },
        page(){
            this.broadcast()
        }
    },    
    computed :{
          shouldPaginate(){
              return !! this.prevUrl || !! this.nextUrl
          },
          pages(){
            var pages = [];
            var ctr  = 1;
            for(var x=1; x<=this.page_count-1;x++){
                pages.push(x)
                ctr++
                if(ctr == 5){
                    return pages;
                }
            }
           
            // return this.page_count;
          }
    },
    
    
}
</script>