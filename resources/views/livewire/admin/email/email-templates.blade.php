@php
    use App\Enums\EmailTemplateEnum;
@endphp

<div>
    <p class="text-base mb-6">
        <span class="font-bold">{userName}</span> - it's a placeholder for the name of the user<br/>
        <span class="font-bold">{date}</span> - it's a placeholder for date
    </p>
    @foreach($templates as $key => $template)
        @component('parts.layouts.card', [
            'class' => 'mb-6 border-[1px] border-gray-100'
        ])
            <p class="card-title">{{ $template['name'] }} Template</p>
            @switch($template['name'])
                @case(EmailTemplateEnum::PASSWORD_RESET->value)
                    <p class="text-base mb-6">
                        <span class="font-bold">{resetLink}</span> - link to reset password<br/>
                    </p>
                    @break
                @case(EmailTemplateEnum::ORDERED->value)
                    <p class="text-base mb-6">
                        <span class="font-bold">{count}</span> - count of products<br/>
                    </p>
                    @break
            @endswitch

            @include('parts.form.input', [
                'model' => 'templates.'.$key.'.subject',
                'title' => 'Subject'
            ])
            @include('parts.form.textarea', [
                'model' => 'templates.'.$key.'.body',
                'title' => 'Body',
                'class' => 'max-h-[400px]'
            ])
            <div class="flex items-center justify-center gap-3">
                <button type="button" wire:click="saveTemplate('{{ $template['name'] }}')" class="btn btn-primary">Save</button>
            </div>
        @endcomponent
    @endforeach
{{--    @for($i = 0; $i < count($templates); $i++)--}}
{{--        @component('parts.layouts.card', [--}}
{{--            'class' => 'mb-6 border-[1px] border-gray-100'--}}
{{--        ])--}}
{{--            <p class="card-title">{{ $templates[$i]['name'] }} Template</p>--}}
{{--            @switch($templates[$i]['name'])--}}
{{--                @case(EmailTemplateEnum::PASSWORD_RESET->value)--}}
{{--                    <p class="text-base mb-6">--}}
{{--                        <span class="font-bold">{resetLink}</span> - link to reset password<br/>--}}
{{--                    </p>--}}
{{--                    @break--}}
{{--            @endswitch--}}
{{--            @include('parts.form.input', [--}}
{{--                'model' => 'templates.'. $i .'.subject',--}}
{{--                'title' => 'Subject'--}}
{{--            ])--}}
{{--            @include('parts.form.textarea', [--}}
{{--                'model' => 'templates.'. $i .'.body',--}}
{{--                'title' => 'Body',--}}
{{--                'class' => 'max-h-[400px]'--}}
{{--            ])--}}
{{--            <div class="flex items-center justify-center gap-3">--}}
{{--                <button type="button" wire:click="saveTemplate('{{ $templates[$i]['name'] }}')" class="btn btn-primary">Save</button>--}}
{{--            </div>--}}
{{--        @endcomponent--}}
{{--    @endfor--}}
</div>
