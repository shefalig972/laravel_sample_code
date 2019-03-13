<div class="box-body">
    <div class="form-group {{ $errors->has('firstname') ? 'has-error' : ''}}">
        <label>{{Helper::languageTranslation('First Name')}}<i class="fa fa-asterisk asterik" aria-hidden="true"></i><?php echo Helper::tooltip(Helper::languageTranslation('Enter firstname of employee.')); ?></label>
        <input class="form-control" name="firstname" placeholder="{{Helper::languageTranslation('First name')}}" type="text" value="{{ $employee->firstname or old('firstname')}}" autocomplete="off">
        {!! $errors->first('firstname','<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group {{ $errors->has('lastname') ? 'has-error' : ''}}">
        <label>{{Helper::languageTranslation('Last Name')}}<i class="fa fa-asterisk asterik" aria-hidden="true"></i><?php echo Helper::tooltip(Helper::languageTranslation('Enter lastname of employee.')); ?></label>
        <input class="form-control" name="lastname" placeholder="{{Helper::languageTranslation('Last name')}}" type="text" value="{{ $employee->lastname or old('lastname') }}" autocomplete="off" >
        {!! $errors->first('lastname','<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
        <label>{{Helper::languageTranslation('Email')}}<i class="fa fa-asterisk asterik" aria-hidden="true"></i><?php echo Helper::tooltip(Helper::languageTranslation('Enter email address of employee.')); ?></label>
        <input class="form-control" name="email" placeholder="{{Helper::languageTranslation('abc@xyz.com')}}" type="text" value="{{ $employee->email or old('email') }}" autocomplete="off">
        {!! $errors->first('email','<p class="help-block">:message</p>') !!}
    </div>
    <input type="hidden" name="record_id" value="{{@$employee->id}}"/>
    <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
        <label> {{Helper::languageTranslation('Gender')}}<i class="fa fa-asterisk asterik" aria-hidden="true"></i><?php echo Helper::tooltip(Helper::languageTranslation('Select gender of employee.')); ?></label>
        <div class="gender-box">
            <div class="gender-box-inner">
                <input 
                <?php
                if (@$employee->gender === 'male' || old('gender') === 'male') {
                    echo 'checked';
                }
                ?> 
                    type="radio" name="gender" value="male" autocomplete="off"> {{Helper::languageTranslation('Male')}}
            </div>
            <div class="gender-box-inner">
                <input 
                <?php
                if (@$employee->gender === 'female' || old('gender') === 'female') {
                    echo 'checked';
                }
                ?>
                    type="radio" name="gender" value="female" autocomplete="off"> {{Helper::languageTranslation('Female')}}
            </div>

        </div>
        {!! $errors->first('gender','<p class="help-block">:message</p>') !!}
    </div>


    <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
        <label>{{Helper::languageTranslation('Select Default Language')}}<i class="fa fa-asterisk asterik" aria-hidden="true"></i><?php echo Helper::tooltip(Helper::languageTranslation('Select the language for employee.')); ?></label>
        <select class="form-control" name="user_language">
            <option value="">{{Helper::languageTranslation('select')}}</option>
            @if($ActiveLanguages)
            @foreach($ActiveLanguages as $k=>$v)
            <?php
            $selectedLanguage = '';
            if ($v->id == @$employee->user_language or old('user_language') == $v->id) {
                $selectedLanguage = 'selected="selected"';
            }
            ?>
            <option <?php echo $selectedLanguage; ?> value="{{$v->id}}">{{ucfirst($v->language)}}</option>
            @endforeach
            @endif 
        </select>
        {!! $errors->first('user_language','<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="box-footer">
    <?php
    $type = "button";
    $btnClass = "add-client-btn1";
    if (isset($employee) and ! empty($employee)) {
        $type = "submit";
        $btnClass = "btn-primary add-client-btn";
    }
    ?>
    <button type="{{$type}}" class="btn {{$btnClass}} add-employee-submit">{{Helper::languageTranslation('Submit')}}</button>

    <a href="{{ url($Prefix.'/employee') }}" class="btn btn-danger add-client-btn1">{{Helper::languageTranslation('Cancel')}}</a>
</div>