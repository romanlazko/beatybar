
<x-white-block class="h-min space-y-4 confirmation p-4 sm:p-8">
    <x-confirmation.header :confirmation="$confirmation"/>
                            
    <div class="space-y-0">
        <x-confirmation.city-block :confirmation="$confirmation"/>

        <x-confirmation.bank-block :confirmation="$confirmation"/>

        <x-confirmation.date-block :confirmation="$confirmation" :index="$index"/>

        <x-confirmation.cost-block :confirmation="$confirmation" :index="$index"/>

        <br>

        <x-confirmation.prev-comment-block :confirmation="$confirmation" :index="$index"/>
        
        <x-confirmation.post-comment-block :confirmation="$confirmation" :index="$index"/>
        
        <x-confirmation.banker-block :confirmation="$confirmation" :index="$index"/>

        <x-confirmation.manager-block :confirmation="$confirmation" :index="$index"/>

        <x-confirmation.change-status-block :confirmation="$confirmation" :index="$index"/>
    </div>
</x-white-block>
