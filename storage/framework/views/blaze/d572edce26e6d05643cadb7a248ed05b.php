<?php
if (!function_exists('__d572edce26e6d05643cadb7a248ed05b')):
function __d572edce26e6d05643cadb7a248ed05b($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
extract(Flux::forwardedAttributes($attributes, [
    'tooltipPosition',
    'tooltipKbd',
    'tooltip',
]));
?>

<?php $tooltipPosition = $tooltipPosition ??= $attributes->pluck('tooltip:position'); ?>
<?php $tooltipKbd = $tooltipKbd ??= $attributes->pluck('tooltip:kbd'); ?>
<?php $tooltip = $tooltip ??= $attributes->pluck('tooltip'); ?>

<?php
$__defaults = [
    'tooltipPosition' => 'top',
    'tooltipKbd' => null,
    'tooltip' => null,
];
$tooltipPosition ??= $attributes['tooltip-position'] ?? $attributes['tooltipPosition'] ?? $__defaults['tooltipPosition']; unset($attributes['tooltipPosition'], $attributes['tooltip-position']);
$tooltipKbd ??= $attributes['tooltip-kbd'] ?? $attributes['tooltipKbd'] ?? $__defaults['tooltipKbd']; unset($attributes['tooltipKbd'], $attributes['tooltip-kbd']);
$tooltip ??= $attributes['tooltip'] ?? $__defaults['tooltip']; unset($attributes['tooltip']);
unset($__defaults);
?>

<?php if ($tooltip): ?>
    <?php $__blaze->ensureRequired('F:\Projects\dr.Rajendra\project 001\spmApp\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/ba412282d3945a194a8ff5dc28634ccb.php'); ?>
<?php if (isset($__slotsba412282d3945a194a8ff5dc28634ccb)) { $__slotsStackba412282d3945a194a8ff5dc28634ccb[] = $__slotsba412282d3945a194a8ff5dc28634ccb; } ?>
<?php if (isset($__attrsba412282d3945a194a8ff5dc28634ccb)) { $__attrsStackba412282d3945a194a8ff5dc28634ccb[] = $__attrsba412282d3945a194a8ff5dc28634ccb; } ?>
<?php $__attrsba412282d3945a194a8ff5dc28634ccb = ['content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slotsba412282d3945a194a8ff5dc28634ccb = []; ?>
<?php $__blaze->pushData($__attrsba412282d3945a194a8ff5dc28634ccb); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsba412282d3945a194a8ff5dc28634ccb['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsba412282d3945a194a8ff5dc28634ccb); ?>
<?php __ba412282d3945a194a8ff5dc28634ccb($__blaze, $__attrsba412282d3945a194a8ff5dc28634ccb, $__slotsba412282d3945a194a8ff5dc28634ccb, ['content', 'position', 'kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackba412282d3945a194a8ff5dc28634ccb)) { $__slotsba412282d3945a194a8ff5dc28634ccb = array_pop($__slotsStackba412282d3945a194a8ff5dc28634ccb); } ?>
<?php if (! empty($__attrsStackba412282d3945a194a8ff5dc28634ccb)) { $__attrsba412282d3945a194a8ff5dc28634ccb = array_pop($__attrsStackba412282d3945a194a8ff5dc28634ccb); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH F:\Projects\dr.Rajendra\project 001\spmApp\vendor\livewire\flux\src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>