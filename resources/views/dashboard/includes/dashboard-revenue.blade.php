 <div>
     <h3 class="text-3xl font-semibold mb-4">{{ __('payment.revenue') }}</h3>
     <div class="flex flex-wrap justify-between">
         <div class="flex flex-col justify-center items-center p-8 bg-blue-300 rounded-2xl">
             <strong class="text-xl">
                 {{ trans('payment.daily_revenue') }}
             </strong>
             <div class="mt-2">
                 {{ formatNumber($dailyRevenue, 'VND') }}
             </div>
         </div>
         <div class="flex flex-col justify-center items-center p-8 bg-green-300 rounded-2xl">
             <strong class="text-xl">
                 {{ trans('payment.weekly_revenue') }}:
             </strong>
             <div class="mt-2">
                 {{ formatNumber($weeklyRevenue, 'VND') }}
             </div>
         </div>
         <div class="flex flex-col justify-center items-center p-8 bg-indigo-400 rounded-2xl">
             <strong class="text-xl">
                 {{ trans('payment.monthly_revenue') }}:
             </strong>
             <div class="mt-2">
                 {{ formatNumber($monthlyRevenue, 'VND') }}
             </div>
         </div>
     </div>
 </div>
