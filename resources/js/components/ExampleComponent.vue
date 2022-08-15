<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    export default {
        mounted() {
            console.log('Component mounted.')
            let btn = document.getElementById('good');
btn.addEventListener('click',function(){
    let $this = $(this); 
    let tweet_id = $this.data('tweet-id');
    console.log(tweet_id)
});
        }
    }
</script>
