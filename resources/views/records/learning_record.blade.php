<div class="row justify-content-center">
  <div class="col-sm-12 col-md-11 col-lg-10 offset-lg-1">
    <h1 class="mb-4">{{ $hasRecordsTitle ? '学習記録一覧' : ''}}</h1>
    <hr>
    <table class="table table-borderless">
      <tbody>
        @foreach ($hasRecords ? $records : $user->likes as $record)
        <tr class="h5">
          <td>
            {{ $record->learning_date }}
            {{ $record->user->name }} さん
          </td>
        </tr>
        <tr class="h5">
          <td>学習時間{{ $record->duration }} 分</td>
        </tr>
        <tr>
          <td class="h3"><a href="{{ route('records.show', ['record' => $record->id]) }}">
              {{ $record->title }}
            </a></td>
        </tr>
        <tr>
          <td>
            @foreach($record->tags as $tag)
            <span>{{ $tag->name }}</span>
            @endforeach
            @if (Helper::isWithinMaxCharacters($record->body))
            <p>{{ $record->body }}</p>
            @else
            <p>{{ Helper::truncateText($record->body) }}</p>
            @endif
            <hr>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ isset($records) ? $records->links() : $likes->links()}}
  </div>
</div>