<template>
	<div class="group-wrapper">
        <div class="card pb-4">
            <b-button @click="showModal" variant="primary" id="24">Show Modal</b-button>
        </div>
        <light-modal :show="status">
            <template #body>
               <input type="text" class="form-control" v-model="text">
            </template>
        </light-modal>
	</div>
</template>

<script>
import Modal from "./ModalComponent";
    export default {
        components: {
            Modal
        },
        methods: {
            showModal(){
                this.status = true
            }
        },
        data(){
            return {
                status: false,
                text: null
            }
        }
    }
</script>
