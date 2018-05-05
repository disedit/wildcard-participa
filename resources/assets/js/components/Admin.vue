<template>
  <div>
    <div class="dashboard" v-if="!screen_locked">
      <navbar @lock="lockScreen" />
      <div class="container mb-5">
        <edition @lock="lockScreen" />
        <div v-if="is_superadmin" class="row">
          <div class="col-md-8">
            <results />
          </div>
          <div class="col-md-4">
            <reports />
          </div>
        </div>
      </div>
    </div>
    <lock-screen v-else />
  </div>
</template>

<script>
  import Navbar from './admin/Navbar';
  import Edition from './admin/Edition';
  import Results from './admin/Results';
  import Reports from './admin/Reports';
  import LockScreen from './admin/LockScreen';

  export default {
    name: 'admin',

    components: {
      Navbar,
      Edition,
      Results,
      Reports,
      LockScreen
    },

    data() {
      return {
        is_superadmin: false,
        screen_locked: false
      }
    },

    created() {
      if(window.app.user.is_superadmin)
        this.is_superadmin = true;
    },

    methods: {
      lockScreen() {
        Participa.lock(true)
          .then(response => {
            this.screen_locked = true;
          });
      }
    }
  }
</script>
