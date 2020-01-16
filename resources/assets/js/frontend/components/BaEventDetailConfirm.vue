<template>
    <div class="event-confirm">
        <div class="columns">
            <div class="column auto event-confirm__left">
                <div v-for="field in currentEventFields.fields">
                    <div class="event-confirm__label text" v-text="field.field_label + ':'"></div>
                </div>
            </div>
            <div class="column is-four-fifths event-confirm__right">
                <div v-for="field in currentEventFields.fields">
                    <vue-markdown class="event-confirm__value text" v-if="field.type === 'textarea' && field.allow_markdown">{{field.field_value}}</vue-markdown>
                    <div class="event-confirm__value text" v-else>
                        {{ field.field_value ? field.field_value : '&nbsp' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        data () {
            return {

            }
        },
        computed: {
            ...mapGetters('Events', {
                currentEventFields: 'getCurrentEventFields'
            })
        }
    }
</script>

<style lang="scss">
    .event-confirm {
        background-color: white;
        max-height: 65vh;
        overflow: scroll;
        border: 1px solid #bebebe;
        padding: 15px 25px;

        &__left {
        }

        &__right {
        }

        &__label {
            padding-bottom: 25px;
            font-weight: bold;
        }
        &__value {
            padding-bottom: 25px;
        }
    }
</style>
