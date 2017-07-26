<template>
    <b-modal id="anullBallot" ref="anullBallot" @shown="focusID" @hidden="clear">
        <div slot="modal-title">
            <span class="title">Anul·la una papereta</span>
        </div>

        <form @submit.prevent="ballotLookup">
            <div :class="{ 'form-group': true, 'has-warning': (errors.ID) }">
                <label for="ID">Identificador</label>
                <input v-if="step == 1" type="text" v-model="ID" class="form-control form-control-warning" ref="ID" id="ID" placeholder="DNI, NIF o Passaport" />
                <div v-if="errors.ID" class="form-control-feedback">{{ errors.ID }}</div>
                <p v-if="step == 2">
                    <strong>{{ ID }}</strong>
                    <a href="#" @click.prevent="back"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </p>
            </div>

            <div v-if="step == 2">
                <div class="form-group">
                    <label for="reason" class="mb-0">Justificació</label>
                    <small class="form-text text-muted mt-0 mb-1">Breu descripció de l'incident pel qual s'anul·la aquesta papereta.</small>
                    <textarea ref="reason" id="reason" class="form-control"></textarea>
                </div>

                <div class="form-group mb-0">
                    <label class="mb-0">Signatura</label>
                    <p class="mb-0"><strong>{{ user.name }} @ {{ ip }}</strong></p>
                    <hr class="my-3" />
                    <small class="form-text text-muted mt-0">Aquesta acció quedarà registrada a la base de dades per raons de seguretat.</small>
                </div>
            </div>
        </form>

        <div slot="modal-footer">
            <button class="btn btn-secondary" @click="hideModal">Tanca</button>
            <button v-if="step == 1" class="btn btn-danger" @click.prevent="ballotLookup"><i class="fa fa-search" aria-hidden="true"></i> Troba la papereta</button>
            <button v-if="step == 2" class="btn btn-danger" @click.prevent="anullBallot"><i class="fa fa-ban" aria-hidden="true"></i> Anul·la la papereta</button>
        </div>
    </b-modal>
</template>

<script>
    export default {
        name: 'anull-ballot',

        data() {
            return {
                step: 1,
                ID: '',
                reason: '',
                user: { name: '' },
                ip: '',
                errors: {
                    ID: null,
                    reason: null
                }
            }
        },

        mounted() {
            this.user = window.app.user;
            this.ip = window.app.ip;
        },

        watch: {
            ID: function(value) {
                if(value.length != 0) {
                    this.$set(this.errors, 'ID', null);
                }
            },

            step: function(step) {
                if(step == 2) {
                    this.$refs.reason.focus();
                } else if(step == 1) {
                    this.$refs.ID.focus();
                }
            }
        },

        methods: {
            focusID() {
                this.$refs.ID.focus();
                console.log(this.$refs.ID);
            },

            ballotLookup() {
                if(this.ID.length == 0) {
                    this.$set(this.errors, 'ID', 'El camp Identificador és obligatòri.');
                    this.$refs.ID.focus();
                    return;
                }

                Participa.anullBallot({ ID }).then(response => {
                    this.step = 2;
                }).catch(errors => {
                    this.$set(this.errors, 'ID', 'Error with ballot');
                });
            },

            anullBallot() {

            },

            hideModal() {
                this.$refs.anullBallot.hide();
            },

            clear() {
                this.ID = '';
                this.reason = '';
                this.step = 1;
            },

            back() {
                this.step = 1;
            },
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../sass/_variables';

    .title {
        color: $red;
    }
</style>
