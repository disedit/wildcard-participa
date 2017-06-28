<template>
        <div class="modal fade in" style="display:block;" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button @click="close()" name="close" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <slot name="header" class="modal-title" id="ModalLabel">Title</slot>
              </div>
              <div class="modal-body">
                <slot></slot>
              </div>
              <slot name="buttons" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </slot>
            </div>
          </div>
        </div>
</template>

<script>
    export default {
        name: 'modal',

        props: {
            onclose: Function
        },

        methods: {
            close() {
                this.onclose;
            }
        }
    }
</script>
