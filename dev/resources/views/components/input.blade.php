@if(!empty($label))
    <label class="{{$labelClass ?? ""}}">
        <span>@if($required ?? true)<span title="required" class="required">*</span>@endif{{$label}}</span>
        @endif
        <input name="{{$name ?? $label ?? ""}}" class="{{$class ?? "input"}}" type="{{$type ?? "text"}}"
               placeholder="{{$placeholder ?? ""}}"
               value="{{$value ?? ""}}">
        @if(!empty($label))
    </label>
@endif
