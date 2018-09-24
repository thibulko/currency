<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body style="margin-top: 80px;">
        <div class="container">
            @if (empty($sid))
                <div class="text-center">
                    <form action="{{ route('auth') }}">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </form>
                </div>
            @endif

            <div class="accordion" id="accordionCurrencies">
                @if (isset($currencies))
                    @foreach ($currencies as $cur)
                    <div class="card">
                        <div class="card-header" id="headingCurrencies-{{ $cur->id() }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseCurrencies-{{ $cur->id() }}" aria-expanded="false" aria-controls="collapseCurrencies-{{ $cur->id() }}">
                                    {{ $cur->name() }} ({{ $cur->code() }})
                                </button>
                            </h5>
                        </div>
                        <div id="collapseCurrencies-{{ $cur->id() }}" class="collapse" aria-labelledby="headingCurrencies-{{ $cur->id() }}" data-parent="#accordionCurrencies">
                            <div class="card-body">
                                @if ($cur->rates())
                                    <ul>
                                        @foreach ($cur->rates() as $rate)
                                            <li>{{ $currencies->get($rate->to())->code() }} - {{ $rate->rate() }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
