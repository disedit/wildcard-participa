<template>
    <b-modal id="anullBallot" ref="anullBallot" @shown="focusID" @hidden="clear">
        <div slot="modal-title">
            <span class="title">Anul·la una papereta</span>
        </div>

        <div class="alert alert-success" v-if="success">
            <i class="fa fa-check" aria-hidden="true"></i> Papereta anul·lada correctament.
        </div>

        <form @submit.prevent="ballotLookup">
            <div :class="{ 'form-group': true, 'has-warning': (errors.ID) }">
                <label for="ID">Identificador</label>
                <input v-if="step == 1" type="text" v-model="ID" class="form-control form-control-warning" ref="ID" id="ID" placeholder="DNI, NIF o Passaport" />
                <p v-if="step == 2">
                    <strong>{{ ID }}</strong>
                    <a href="#" @click.prevent="back"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </p>
                <div v-if="errors.ID" v-for="error in errors.ID" class="form-control-feedback">{{ error }}</div>
            </div>

            <div v-if="step == 2">
                <div :class="{ 'form-group': true, 'has-warning': (errors.reason) }">
                    <label for="reason" class="mb-0">Justificació</label>
                    <small class="form-text text-muted mt-0 mb-1">Breu descripció de l'incident pel qual s'anul·la aquesta papereta.</small>
                    <textarea ref="reason" id="reason" v-model="reason" class="form-control form-control-warning"></textarea>
                    <div v-if="errors.reason" v-for="error in errors.reason" class="form-control-feedback">{{ error }}</div>
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
                success: false,
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
                Participa.anullBallot({
                    ID: this.ID
                }).then(response => {
                    this.step = 2;
                }).catch(errors => {
                    this.errors = errors;
                    this.$refs.ID.focus();
                });
            },

            anullBallot() {
                Participa.anullBallot({
                    ID: this.ID,
                    reason: this.reason,
                    confirm: true
                }).then(response => {
                    this.clear();
                    this.success = true;
                }).catch(errors => {
                    this.errors = errors;
                    this.$refs.reason.focus();
                });
            },

            hideModal() {
                this.$refs.anullBallot.hide();
            },

            clear() {
                this.ID = '';
                this.reason = '';
                this.step = 1;
                this.success = false;
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
