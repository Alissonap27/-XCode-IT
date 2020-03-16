<template>
    <div class="row" v-if="hasMessage()">
        <div class="col-md-12 ">
            <div class="text-center alert alert-danger alert-dismissible" id="error_message">
                <a @click="close()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{message}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["message"],
        methods: {
            hasMessage: function(){
                return this.message;
            },
            close: function(){
                this.$emit('close')
            }
        },
    };
</script>
