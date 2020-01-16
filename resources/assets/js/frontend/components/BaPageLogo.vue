<template>
    <div class="page-logo">
        <div class="page-logo__wrap">
            <div class="page-logo__img" :class="type ? type: ''"></div>
        </div>
    </div>
</template>

<script>
    export default  {
        props: {
            type: {
                type: String,
                default: ''
            }
        }
    }
</script>

<style lang="scss">
    .page-logo {
        position: relative;
        width: 60px;
        height: 100%;

        &__wrap {
            position: absolute;
            z-index: 12;
            top: 30px;
            left: 15px;
            width: 100%;
            height: 100%;
        }
        &__img {
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            padding-bottom: 54.66%;
            background-image: url("../../../../images/logo--short.png");
        }
    }
</style>
