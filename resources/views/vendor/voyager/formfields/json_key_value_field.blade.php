@php
    $values = $dataTypeContent->{$row->field};
    if (is_string($values)) { $values = json_decode($values, true); }
    if (empty($values)) {
        $values = array();
    }
@endphp
<div class="custom-field is-field-{{$row->field}}">
    <div id="key_value_{{$row->field}}">
        @if($values)
            @foreach($values as $index => $value)
                <div class="row mb-3">
                    <div class="col-md-10">
                        @for($i = 0; $i < count($row->details->values); $i++)
                            @if($i > 0)
                                <br>
                            @endif
                            @if($row->details->values[$i]->field === 'textarea')
                                <textarea
                                        class="form-control"
                                        name="{{ $row->field}}[{{$index}}][{{$i}}]"
                                        placeholder="{{$row->details->values[$i]->placeholder}}"
                                        @if($row->required == 1) required @endif
                            >{{$value[$i]}}</textarea>
                            @else
                                <input
                                        class="form-control"
                                        name="{{ $row->field}}[{{$index}}][{{$i}}]"
                                        placeholder="{{$row->details->values[$i]->placeholder}}"
                                        value="{{$value[$i]}}"
                                        @if($row->required == 1) required @endif
                                >
                            @endif
                        @endfor
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="recalculateIndexBlockRow(this);">
                            Удалить
                        </button>
                    </div>
                </div>
            @endforeach
        @endempty
    </div>
    <button type="button"
            class="btn btn-block btn-info"
            onclick="addRowToBlock()">
        Добавить еще
    </button>
</div>
@php $dataTypeContent->{$row->field} = $values; @endphp
<script type="template/html" id="template_key_value_{{$row->field}}">
    <div class="row">
        <div class="col-md-10">
            @for($i = 0; $i < count($row->details->values); $i++)
                @if($i > 0)
                    <br>
                @endif

                @if($row->details->values[$i]->field === 'textarea')
                    <textarea
                            class="form-control"
                            name="{{ $row->field}}[@index@][{{$i}}]"
                            placeholder="{{$row->details->values[$i]->placeholder}}"
                            @if($row->required == 1) required @endif
                            ></textarea>
                @else
                    <input
                            class="form-control"
                            name="{{ $row->field}}[@index@][{{$i}}]"
                            placeholder="{{$row->details->values[$i]->placeholder}}"
                            value=""
                            @if($row->required == 1) required @endif
                    >
                @endif
            @endfor
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm"
                    onclick="recalculateIndexBlockRow(this);">
                Удалить
            </button>
        </div>
    </div>
</script>
@push('javascript')
    <script>
        function addRowToBlock() {
            var $blockKeyValue = $('#key_value_{{$row->field}}');
            var $tr = $('#template_key_value_{{$row->field}}').text().replace(/@index@/gi, $blockKeyValue.children('' +
                '.row')
                .length);
            $blockKeyValue.append($tr);
        }

        function recalculateIndexBlockRow(btn) {
            $(btn).closest('.row').remove();
            var regexName = /(.+\[)\d{0,}(\].+)/gi;
            $('#key_value_{{$row->field}} > .row').each(function (index, row) {
                console.log(row)
                $(row).find('input, textarea').each(function (i, input) {
                    $(input).attr('name', $(input).attr('name').replace(regexName, '$1' + index + '$2'));
                });
            });
        }
    </script>
@endpush