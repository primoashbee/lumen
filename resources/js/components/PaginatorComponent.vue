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
            <li class="page-item" v-bind:class="pageItem ==page?'page-active':''" v-for="pageItem in pages" :key="pageItem.id">
                <a class="page-link" style="color:black"  href="#" @click.prevent="changePage(pageItem)">{{pageItem}}</a>
            </li>
            <li class="page-item" v-show ="nextUrl">
            <a class="page-link" href="#" style="color:black" aria-label="Next" @click.prevent="page++">
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
            total_pages: 0,
            last_page: false,
            first_page: false,
            
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
                this.total_pages = this.dataset.last_page
                this.first_page = this.dataset.first_page
                this.last_page = this.dataset.last_page
            }
        },
        page(){
            this.broadcast()
        }
    },    
    computed :{
            visiblePageCount(){
                if(this.total_pages < 5){
                    return this.total_pages
                }
                return 5;
            },
            shouldPaginate(){
                return !! this.prevUrl || !! this.nextUrl
            },
            pages(){
            var pages = [];
            var ctr  = 0;
            if(this.aboveMaxPageLimit){
                
                for(var x = this.total_pages; x > this.total_pages-this.visiblePageCount ; x--){
                    pages.push(x)
                }
                return pages.reverse();
            }
            for(var x=this.page; x<=this.total_pages-1;x++){
                pages.push(x)
                ctr++
                if(ctr == this.visiblePageCount){
                    return pages;
                }
            }

            // return this.total_pages;
            },
            aboveMaxPageLimit(){
                return this.page + this.visiblePageCount > this.last_page
            }
    },
    
    
}
</script>

<style scoped>
.page-active{
    background-color: #fdad7d !important;
}
</style>