<h1>Retatório de faturamento diário</h1>

<p>Olá {{$seller['name']}}, veja seu faturamento diário</p>

<ul>
    <li>
        <strong>Total:</strong>{{money_format('%i', $seller['total'])}}
    </li>
    <li>
        <strong>Total:</strong>{{money_format('%i', $seller['commission'])}}
    </li>
    <li>
        <strong>Período:</strong>{{now()->format ('d/m/Y')}}
    </li>
</ul>

<p>
    Atenciosamente,<br>
    {{ config('app.name') }}
</p>