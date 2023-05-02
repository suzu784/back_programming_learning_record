<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 offset-md-2">
        <form method="POST" action="{{ isset($record) ? route('records.update', $record) : route('records.store') }}">
            @csrf
            @if(isset($record))
            @method('PUT')
            @endif
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="learning_date">学習日:</label>
                    <input type="date" class="form-control" id="learning_date" name="learning_date"
                        value="{{ old('learning_date', isset($record) ? $record->learning_date : date('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label for="duration">学習時間:</label>
                    <input type="time" name="duration" id="duration" class="form-control"
                        value="{{ old('duration', isset($record) ? sprintf('%02d:%02d', $hours, $minutes) : '00:00') }}">
                </div>
            </div>
            <div class="form-group row mt-2">
                <div class="col-md-11">
                    <label for="title">タイトル:</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', isset($record) ? $record->title : '') }}">
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="body">学習内容:</label>
                <textarea name="body" id="body" class="form-control" cols="40"
                    rows="15">{{ old('body', isset($record) ? $record->body : '') }}</textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ isset($record) ? '更新' : '登録' }}</button>
            </div>
        </form>
    </div>
</div>