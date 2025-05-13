
<div class="max-w-5xl mx-auto p-8 bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg shadow-gray-200/50 space-y-8" dir="rtl">
<?php 
use App\HTMLRenderer\Navbar;
$categories_nav=new Navbar([
  'brand'=>['label'=>'همه چیز', 'class'=>'text-white bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600 px-6 py-3 rounded-lg font-bold text-xl shadow-lg transform transition-all duration-300 hover:scale-105','href'=>route('ietannounce.all',['filter'=>''])],
  'items'=>[
    ['label'=>'املاک و مسکن','href'=>route('ietannounce.filtered',['filter'=>'housing']),'class'=>'text-yellow-300 m-2 p-3 bg-red-500 rounded-lg font-bold'],
    ['label'=>'غذا و خوراکی','href'=>route('ietannounce.filtered',['filter'=>'food']),'class'=>'text-yellow-300 m-2 p-3 bg-red-500 rounded-lg font-bold'],
    ['label'=>'لباس و پوشاک','href'=>route('ietannounce.filtered',['filter'=>'wear']),'class'=>'text-yellow-300 m-2 p-3 bg-red-500 rounded-lg font-bold'],
    ['label'=>'حمل و نقل','href'=>route('ietannounce.filtered',['filter'=>'transportation']),'class'=>'text-yellow-300 m-2 p-3 bg-red-500 rounded-lg font-bold'],
    ['label'=>'آموزشی','href'=>route('ietannounce.filtered',['filter'=>'education']),'class'=>'m-2 p-3 bg-red-500 text-yellow-300 rounded-lg font-bold'],
  ]
]);
echo $categories_nav->render([]);


$sdsg_nav=new Navbar([
  'brand'=>'',
  'items'=>[
    ['label'=>'عرضه','href'=>route('ietannounce.filtered',['filter'=>'supply']),'class'=>'m-2 p-3 bg-black text-yellow-300 rounded-lg font-semibold'],
    ['label'=>'تقاضا','href'=>route('ietannounce.filtered',['filter'=>'demand']),'class'=>'m-2 p-3 bg-black text-yellow-300 rounded-lg font-semibold'],
    ['label'=>'خدمات','href'=>route('ietannounce.filtered',['filter'=>'services']),'class'=>'m-2 p-3 bg-black text-yellow-300 rounded-lg font-semibold'],
    ['label'=>'کالا','href'=>route('ietannounce.filtered',['filter'=>'goods']),'class'=>'m-2 p-3 bg-black text-yellow-300 rounded-lg font-semibold'],

  ]
]);
echo $sdsg_nav->render();
?>
<h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500 pb-2 border-b border-gray-200">اعلانات سیستم</h2>

  <?php if (!empty($announces)): ?>
    <ul class="grid gap-6 md:grid-cols-3">
      <?php foreach ($announces as $announce): ?>
        <li class="bg-white p-6 rounded-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 shadow-sm hover:shadow-md">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($announce['title']) ?></h3>
              <span class="inline-block px-3 py-1 text-sm rounded-full <?= $announce['supply_demand'] === 'عرضه' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' ?>">
                <?= htmlspecialchars($announce['category']) ?> | <?= htmlspecialchars($announce['supply_demand']) ?>
              </span>
            </div>
            <div class="flex space-x-3 space-x-reverse">
              <a href="<?= route('ietannounce.show', ['id' => $announce['id']]) ?>" class="text-blue-600 hover:text-blue-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </a>
            </div>
          </div>
  
        </li>

        
        
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <div class="text-center py-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-700">اعلامی وجود ندارد</h3>
        <a href="<?php echo route('ietannounce.create') ?>" class="bg-yellow-100 rounded-sm">عرضه یا تقاضای خودرا اعلام نمایید</a>
    </div>
  <?php endif; ?>
</div>



