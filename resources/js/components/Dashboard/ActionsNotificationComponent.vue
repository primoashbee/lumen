<template>
    
</template>



<script>
import 'vuejs-noty/dist/vuejs-noty.css'
export default {
    
    created(){
        // console.log('hey')
        // Pusher.logToConsole = true;
        
        var pusher = new Pusher('b44381bd199159ce4d29', {
        cluster: 'ap1'
        });

        var channel = pusher.subscribe('dashboard-notification');
        var vm = this;
        channel.bind('bulk-loan-disbursed', function(data) {
            console.log(data)
            vm.notify(data.message)

        });
        
    },
    methods :{
        notify(msg){
            Noty.setMaxVisible(25)
            // Noty.setProgressBar(true)
            new Noty({
                theme:'sunset',
                type: 'success',
                layout: 'topRight',
                text: msg,
                timeout: 4500,
                // animation: {
                //     open : 'animated fadeInRight',
                //     close: 'animated fadeOutRight'
                // }
            }).show();
    
            
        }
    }
}
</script>




