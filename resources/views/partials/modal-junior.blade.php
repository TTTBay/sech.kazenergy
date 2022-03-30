<!-- Modal -->
<div class="modal fade" id="politicsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div style="max-width: 600px" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{__('site-content.politics_title')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-justify">

                </div>
                <div class="form-group text-center mt-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="politics" name="politics" {{ old('politics') =='on' ? "checked" : "" }}>
                        <label class="form-check-label" for="politics">
                                {{__('questionary.conditions')}}
                        </label>
                    </div>
                    <label for="politics" class="error-politic"></label>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary form-send">{{__('site-content.politics_button')}}</button>
            </div>
        </div>
    </div>
</div>
