<template>
  <div class="card mt-4">
    <div class="card-body">
      <div class="d-flex align-items-center">
        <h3>Incidències</h3>
        <div class="ml-auto">
          <a href="#" @click.prevent="loadReports()">
            <i class="far fa-redo" aria-hidden="true"></i>
          </a>
        </div>
      </div>

      <hr class="mt-2 mb-3" />

      <div v-if="!loading" class="report-wrapper">
        <div v-if="reports.length > 0">
          <div :key="key" v-for="(report, key) in reports" class="report">
            <div v-if="report.type == 'limit'">
              <span class="report-icon far fa-ban" aria-hidden="true"></span>
              <div class="report-message" v-if="report.action == 'vote'">
                La IP <a :href="'http://ip-api.com/#' + report.ip" target="_blank" rel="noopener"><strong>{{ report.ip }}</strong></a> ha excedit el límit de vots.
                <div><button @click.prevent="unblock(report.ip)" class="btn btn-outline-secondary btn-sm">Desbloqueja</button></div>
              </div>
              <div class="report-message" v-else>
                La IP <a :href="'http://ip-api.com/#' + report.ip" target="_blank" rel="noopener"><strong>{{ report.ip }}</strong></a> ha sigut bloquejada per intentar esdevinar el camp DNI massa voltes.
                <div><button @click.prevent="unblock(report.ip)" class="btn btn-outline-secondary btn-sm">Desbloqueja</button></div>
              </div>
              <div class="report-info">
                {{ report.created_at }}
              </div>
            </div>

            <div v-else>
              <span class="report-icon far fa-file-alt" aria-hidden="true"></span>
              <div class="report-message">
                {{ report.report }}
              </div>
              <div v-if="report.data.ballot" class="report-data">
                <table class="table table-sm my-2 table-bordered">
                  <tr>
                    <th>ref</th>
                    <td>{{ report.data.ballot.ref }}</td>
                  </tr>
                  <tr v-if="anonymous_voting">
                    <th>dni</th>
                    <td>{{ report.data.voter.SID }}</td>
                  </tr>
                  <tr v-if="anonymous_voting">
                    <th>mòvil</th>
                    <td>{{ report.data.voter.SMS_phone }}</td>
                  </tr>
                  <tr>
                    <th>ip</th>
                    <td>{{ report.data.ballot.ip_address }}</td>
                  </tr>
                  <tr>
                    <th>data</th>
                    <td>{{ report.data.ballot.cast_at }}</td>
                  </tr>
                </table>
              </div>
              <div v-else class="report-data">
                <table class="table table-sm my-2 table-bordered">
                  <tr v-for="(data, key) in report.data" :key="key">
                    <th>{{ key }}</th>
                    <td>{{ data }}</td>
                  </tr>
                </table>
              </div>
              <div class="report-info">
                {{ report.created_at }} | {{ report.user.name }}
              </div>
            </div>
          </div>
        </div>
        <div v-else class="report-empty text-center">
          <span class="far fa-clipboard-check fa-3x fa-tw mt-3"></span>
          <h4 class="mt-2">Cap incidència</h4>
          <p>Tot correcte pel moment.</p>
        </div>
      </div>
      <div v-else class="text-center">
        <i class="far fa-spinner-third fa-spin fa-3x fa-fw mt-3"></i>
        <h4 class="mt-2">Carregant...</h4>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'reports',

    data() {
      return {
        reports: {},
        loading: true,
        anonymous_voting: false,
      }
    },

    mounted() {
      this.loadReports();
      this.anonymous_voting = window.app.config.anonymous_voting;
    },

    methods: {
      /* Fetch results from server */
      loadReports(full) {
        this.loading = true;

        Participa.getReports(full)
          .then(response => {
            this.reports = response.reports;
            this.loading = false;
          });
      },

      /* Unblock an IP */
      unblock(ip) {
        this.loading = true;

        const confirmed = confirm("Estàs segur que vols desbloquejar la IP " + ip + "?");

        if(confirmed) {
          Participa.unblockIp(ip)
            .then(response => {
              this.loadReports(); /* Refresh reports */
            });
        } else {
          this.loading = false;
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import '../../../sass/_variables';

  .report-wrapper {
    max-height: 500px;
    overflow-y: scroll;
  }

  .report {
    padding: 0.5rem 0.5rem 0.5rem 2.5rem;
    border-bottom: 1px $gray-lighter solid;
    position: relative;

    &-icon {
      position: absolute;
      top: 0.75rem;
      left: 0;
      font-size: 2rem;
      color: $gray-light;

      &.fa-ban {
        font-size: 1.75rem;
      }
    }

    &-message {
      .btn-outline-secondary {
        padding: 0.15rem 0.5rem;
        margin: 0.5rem 0;
        font-size: 0.75rem;
        border-radius: 20px;
      }
    }

    &-data {
      .table {
        font-size: 0.75rem;

        td {
          font-family: $font-family-monospace;
        }

        th {
          text-align: right;
          background: $gray-lightest;
        }
      }
    }

    &-info {
      font-size: 0.75rem;
      color: $gray-light;
    }

    &-empty {
      color: $gray-light;
    }
  }

  .report:last-child {
    border-bottom: 0;
  }
</style>
