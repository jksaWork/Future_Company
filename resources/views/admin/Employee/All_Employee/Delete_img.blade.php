<!-- Deleted inFormation Student -->
<div class="modal fade" id="Delete_img{{$attachment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">{{__('translation.Delete_attachment')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('Employee.Delete_attachment')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$attachment->id}}">

                    <input type="hidden" name="student_name" value="{{$attachment->employee->name}}">
                    <input type="hidden" name="student_id" value="{{$attachment->employee->id}}">

                    <h5 style="font-family: 'Cairo', sans-serif;">{{__('translation.Delete_attachment_tilte')}}</h5>
                    <input type="text" name="filename" readonly value="{{$attachment->filename}}" class="form-control">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('translation.Close')}}</button>
                        <button  class="btn btn-danger">{{__('translation.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
