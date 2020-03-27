<template>
    <div>
        <input type="file" @change="onFileSelected">
        <button class="btn-default" @click="submit">Submit</button>
    </div>
</template>


<script>
export default {
    data(){
        return {
            selectedFile: null,
        }
    },
    methods : {
        onFileSelected(e){
            console.log(e.target.files[0])
            this.selectedFile = e.target.files[0]
        },
        submit(){
            let fd = new FormData();
            fd.append('image',this.selectedFile,this.selectedFile.name)
            axios.post('/upload',fd)
                .then(res=>{

        });
        }
    }
}
</script>