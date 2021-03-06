@if(!empty($label))
    <label class="{{$labelClass ?? ""}} {{isset($errorFields) && in_array($name ?? $label ?? "", $errorFields) ? $errorClass :""}}">
        <span>@if($required ?? true)<span title="required" class="required">*</span>@endif{{$label}}</span>
        @endif
        <input name="{{$name ?? $label ?? ""}}" required="{{$required ?? false}}" class="{{$class ?? "input"}}"
               type="{{$type ?? "text"}}"
               placeholder="{{$placeholder ?? ""}}"
               value="{{$value ?? ""}}"
        @foreach($other ?? [] as $attr => $val)
            {{$attr}}="{{$val}}"
        @endforeach
        />
        @if(!empty($label))
    </label>
@endif
