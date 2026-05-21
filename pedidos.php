<?php
// helpers.php — Funciones de presentación (badges, etc.)
function platBadge(string $plat): string {
    $slug = strtolower(str_replace([' ','í','ó'],['','i','o'], $plat));
    $map  = ['didifood'=>'didi','rappi'=>'rappi','whatsapp'=>'whatsapp','presencial'=>'presencial'];
    $cls  = $map[$slug] ?? 'presencial';
    return '<span class="badge badge-'.$cls.'">'.htmlspecialchars($plat).'</span>';
}

function statusBadge(string $estado): string {
    return '<span class="status '.$estado.'">'.ucfirst($estado).'</span>';
}
