@if(!empty($label))
    <label class="{{$labelClass ?? ""}}">
        <span>@if($required ?? true)<span class="required" title="required">*</span>@endif{{$label}}</span>
        @endif
        <textarea required="{{$required ?? false}}" name="{{$name ?? $label ?? ""}}" class="{{$class ?? "textarea"}}"
                  placeholder="{{$placeholder ?? ""}}">{{$value ?? ""}}</textarea>
        @if(!empty($label))
    </label>
@endif

