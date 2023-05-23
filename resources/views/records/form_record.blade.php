<div class="row justify-content-center">
    <div class="col-md-10 col-lg-9">
        <form method="POST" action="{{ isset($record) ? route('records.update', $record) : route('records.store') }}">
            @csrf
            @if(isset($record))
            @method('PUT')
            @endif
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="learning_date">学習日:</label>
                    <input type="date" class="form-control" id="learning_date" name="learning_date"
                        value="{{ old('learning_date', isset($record) ? $record->learning_date : date('Y-m-d')) }}">
                    @if ($errors->first('learning_date'))
                    <p class="validation">※{{$errors->first('learning_date')}}</p>
                    @endif
                </div>
                <div class="col-md-2">
                    <label for="duration">学習時間:</label>
                    <input type="time" name="duration" id="duration" class="form-control"
                        value="{{ old('duration', isset($record) ? sprintf('%02d:%02d', $hours, $minutes) : '00:00') }}">
                    @if ($errors->first('duration'))
                    <p class="validation">※{{$errors->first('duration')}}</p>
                    @endif
                </div>
                <div class="col-md-8">
                    <label for="tagName">タグ:</label>
                    @if(isset($record) && $record->tags->first())
                    @foreach($record->tags as $tag)
                    <input type="hidden" name="tagId[]" value="{{ $tag->id}}">
                    <div id="tag-input">
                        <tag-input :tag-name="{{ json_encode([$record->tags]) }}"></tag-input>
                    </div>
                    @endforeach
                    @else
                    <div id="tag-input">
                        <tag-input :tag-name="[]"></tag-input>
                    </div>
                    @endif
                </div>
            </div>
            <div class="form-group row mt-3">
                <div class="col-md-12">
                    @if ($errors->first('title'))
                    <p class="validation">※{{$errors->first('title')}}</p>
                    @endif
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', isset($record) ? $record->title : '') }}" placeholder="タイトルを入力してください。">
                </div>
            </div>
            <div class="form-group mt-3">
                @if ($errors->first('body'))
                <span class="validation">※{{$errors->first('body')}}</span>
                @endif
                <div id="textarea-modal">
                    <textarea-modal :initial-record-body="{{ isset($record) ? json_encode($record->body) : "''" }}">
                    </textarea-modal>
                </div>
            </div>
            <div class="form-group mt-3">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-info">{{ isset($record) && !$record->is_draft ? '更新' : '投稿'
                        }}</button>
                    @if(isset($record) && $record->is_draft === true)
                    <button type="submit" name="is_draft" class="btn btn-secondary">下書き保存</button>
                    @elseif(!isset($record))
                    <button type="submit" name="is_draft" class="btn btn-secondary">下書き保存</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>