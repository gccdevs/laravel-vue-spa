<template>
    <div class="funding__recent-record">
        <div class="container">
            <div class="funding__recent-record__wrap">
                <div class="funding__recent-record__title">最近记录</div>
                <div class="funding__recent-record__records" v-for="record in records">
                    <div class="funding__recent-record__single">
                        <div class="funding__recent-record__amount">{{ record.amount}}</div>
                        <div class="funding__recent-record__time">{{ record.time}}</div>
                        <div class="funding__recent-record__location">{{ record.location}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                records: [
                    {amount: 100, time: '2018-08-24', location: 'Melbourne'},
                    {amount: 500, time: '2018-08-24', location: 'Melbourne'},
                    {amount: 700, time: '2018-08-23', location: 'Melbourne'},
                    {amount: 200, time: '2018-08-22', location: 'Melbourne'},
                    {amount: 300, time: '2018-08-12', location: 'Melbourne'},
                    {amount: 100, time: '2018-08-11', location: 'Melbourne'},
                ],
            }
        }
    }
</script>

<style lang="scss">
    .funding {
        &__recent-record {
            padding-top: 100px;
            padding-bottom: 100px;
            min-height: 800px;
            background-color: rgb(250, 250, 250);
            &__wrap {
                max-width: 100% !important;
                padding: 0 15px;
            }
        }
    }
</style>
