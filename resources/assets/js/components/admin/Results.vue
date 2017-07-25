<template>
    <div class="card mt-4">
        <div class="card-block">
            <div class="d-flex align-items-center">
                <h3>Resultats</h3>
                <div class="ml-auto results__refresh">
                    <a href="">
                        <i class="fa fa-refresh" aria-hidden="true"></i> Refresca
                    </a>
                </div>
            </div>
            <hr class="mt-2 mb-3" />
            <div class="alert alert-info">
                <i class="fa fa-check" aria-hidden="true"></i> Test d'integritat
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'results',
    }
</script>

<style lang="scss" scoped>
    .results {
        &__refresh a:hover {
            text-decoration: none;
        }
    }
</style>
