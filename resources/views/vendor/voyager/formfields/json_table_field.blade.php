@php
    $values = $dataTypeContent->{$row->field};
    if (is_string($values)) { $values = json_decode($values, true); }
    if (empty($values)) {
        $values = array(
            'title' => '',
            'description' => '',
            'head' => [],
            'body' => []
        );
    }
@endphp
<div class="custom-field is-field-{{$row->field}}">
    <hr>
    <div class="row">
        <div class="col-md-3">
            <label for="{{$row->field}}_title">Заголовок таблицы</label>
        </div>
        <div class="col-md-9">
            <input type="text"
                   class="form-control"
                   @if($row->required == 1) required @endif
                   id="{{$row->field}}_title"
                   name="{{ $row->field }}[title]"
                   value="{{$values->title ?? ''}}">
        </div>
        <div class="col-md-3">
            <label for="{{$row->field}}_description">Описание таблицы</label>
        </div>
        <div class="col-md-9">
            <textarea class="form-control richTextBox"
                      style="height: 5rem;"
                      @if($row->required == 1) required @endif
                      name="{{ $row->field }}[description]"
                      id="richTextBox_{{$row->field}}_description">
                {{$values->description ?? ''}}
            </textarea>
        </div>
    </div>
    <hr>
    <h5>Значения таблицы</h5>
    <table class="table">
        <thead>
        <tr>
            @for($i = 0; $i < $row->details->columns; $i++)
                <th scope="col">
                    <input @if($row->required == 1) required @endif type="text" class="form-control" name="{{ $row->field
    }}[head][]" value="{{$values->head[$i] ?? ''}}" placeholder="Название колонки">
                </th>
            @endfor
            <th></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th colspan="{{$row->details->columns +1}}">
                <button type="button"
                        class="btn btn-block btn-info"
                        onclick="addRowToTable()">
                    Добавить в таблицу
                </button>
            </th>
        </tr>
        </tfoot>
        <tbody id="body_{{$row->field}}">
        @empty($values->body)
            <tr>
                @for($i = 0; $i < $row->details->columns; $i++)
                    <th @if($i === 0)scope="row"@endif>
                        <input @if($row->required == 1) required @endif type="text" class="form-control" name="{{ $row->field
    }}[body][0][{{$i}}]" value="">
                    </th>
                @endfor
            </tr>
        @else
            @foreach($values->body as $index => $row_body)
                <tr>
                    @for($i = 0; $i < $row->details->columns; $i++)
                        <th @if($i === 0)scope="row"@endif>
                            <input
                                    type="text" class="form-control"
                                    @if($row->required == 1) required @endif
                                    name="{{ $row->field }}[body][{{$index}}][{{$i}}]"
                                    value="{{$row_body[$i] ?? ''}}"
                            >
                        </th>
                    @endfor
                    <th>
                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="recalculateIndexInTable(this);">
                            Удалить
                        </button>
                    </th>
                </tr>
            @endforeach
        @endempty
        </tbody>
    </table>
    <hr>
</div>
@php $dataTypeContent->{$row->field} = $values; @endphp
<script type="template/html" id="body_tr_{{$row->field}}">
    <tr>
        @for($i = 0; $i < $row->details->columns; $i++)
            <th @if($i === 0)scope="row"@endif>
                <input
                        type="text" class="form-control"
                        @if($row->required == 1) required @endif
                        name="{{ $row->field }}[body][@index@][{{$i}}]"
                        value=""
                >
            </th>
        @endfor
        <th>
            <button type="button" class="btn btn-danger btn-sm"
                    onclick="recalculateIndexInTable(this);">
                Удалить
            </button>
        </th>
    </tr>
</script>
@push('javascript')
    <script>
        $(document).ready(function () {
            var additionalConfig = {
                selector: '#richTextBox_{{$row->field}}_description',
            }

            $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? '{}') !!})

            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
        });

        function addRowToTable() {
            var $table = $('#body_{{$row->field}}');
            var $tr = $('#body_tr_{{$row->field}}').text().replace(/@index@/gi, $table.find('tr').length);
            $table.append($tr);
        }

        function recalculateIndexInTable(btn) {
            $(btn).closest('tr').remove();
            var regexName = /(.+\[body\]\[)\d{0,}(\].+)/gi;
            $('#body_{{$row->field}} tr').each(function (index, tr) {
                $(tr).find('input').each(function (i, input) {
                    $(input).attr('name', $(input).attr('name').replace(regexName, '$1' + index + '$2'));
                });
            });
        }
    </script>
@endpush