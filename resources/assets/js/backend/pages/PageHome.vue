<template>
    <v-layout row wrap>
        <v-flex xs12 pt-3 pl-3 pb-3>
            <p class="headline">
                Development Notes:
            </p>
        </v-flex>
        <v-flex xs12 class="markdown-preview" pl-3>
            <vue-markdown :source="newNote">
            </vue-markdown>
        </v-flex>
        <v-flex xs12 class="markdown-editor" pl-3>
            <v-textarea color="black" outline v-model="newNote" v-if="onEditing"></v-textarea>
            <v-btn color="primary" @click="save" :disabled="noChange">Save Notes</v-btn>
            <v-btn color="error" @click="onEditing = !onEditing" flat>{{ onEditing ? 'Close' : 'Edit Notes' }}</v-btn>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        data () {
            return {
                note: '',
                newNote: '',
                onEditing: false,
            }
        },
        computed: {
          noChange () {
              return this.note === this.newNote;
          }
        },
        methods: {
            save () {
                let data = {
                    note: this.newNote
                }
                this.$api.postRoute('backend.saveNote', {}, data).then(response => {
                    this.$toasted.success('Notes saved!', {
                        icon: 'repeat_one'
                    });
                    this.onEditing = false;

                }).catch(error => {
                    this.$toasted.error('Failed to save note', {
                        icon: 'repeat_one'
                    });

                })
            }
        },
        mounted () {
            this.$api.getRoute('backend.getNote').then(response => {
                this.note = response.data.note;
                this.newNote = this.note;
            })
        }
    }
</script>

<style lang="scss">
    .markdown-editor {
        margin-top: 45px;
    }
    .markdown-preview {
        border-bottom: 1px dashed black;
        padding-bottom: 45px;
        blockquote {
            margin-top: 15px;
            margin-bottom: 15px;
            border-left: 3px solid gray;
            color: gray;
            font-weight: 700;
            font-style: italic;
        }
    }
</style>