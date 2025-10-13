@props([
    'notifications' => [],
])

@php
    $notifyBag = session()->pull('notify-me', collect([]));
    $sessionNotifications = $notifyBag
        ->map(
            fn($notify) => array_merge($notify, [
                'id' => uniqid(),
                'progressWidth' => 100,
            ]),
        )
        ->all();
@endphp

<div class="fixed bottom-6 right-6 z-50 space-y-4" x-data="{
    notifications: @js($sessionNotifications),
    duration: 5000,
    notifyMe(notify) {
        const notificationData = Array.isArray(notify) ? notify[0] : notify;

        let id = Date.now();

        const newNotification = {
            id: id,
            message: notificationData.message,
            type: notificationData.type || 'info',
            progressWidth: 100,
        };

        this.notifications.push(newNotification);

        setTimeout(() => {
            this.removeMessage(id)
        }, this.duration);

        const interval = 50;
        let elapsed = 0;
        const barUpdate = setInterval(() => {
            elapsed += interval;
            const notification = this.notifications.find(n => n.id === id);

            if (notification) {
                notification.progressWidth = 100 - (elapsed / this.duration * 100);
            }

            if (elapsed >= this.duration || !notification) {
                clearInterval(barUpdate);
            }
        }, interval);
    },

    removeMessage(id) {
        this.notifications = this.notifications.filter(n => n.id !== id)
    }
}" x-init="notifications.forEach(n => {
    setTimeout(() => {
        removeMessage(n.id)
    }, duration);

    const interval = 50;
    let elapsed = 0;
    const barUpdate = setInterval(() => {
        elapsed += interval;
        const notification = notifications.find(msg => msg.id === n.id);

        if (notification) {
            notification.progressWidth = 100 - (elapsed / duration * 100);
        }

        if (elapsed >= duration || !notification) {
            clearInterval(barUpdate);
        }
    }, interval);
});"
    x-on:notify-me.window="notifyMe($event.detail)">

    <template x-for="notification in notifications" :key="notification.id">
        <div class="max-w-sm overflow-hidden rounded-lg border border-neutral-300 bg-neutral-200/10 shadow-sm shadow-neutral-200 backdrop-blur-2xl dark:border-neutral-700 dark:bg-neutral-800/10 dark:shadow-neutral-800"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-full">

            <div class="flex flex-nowrap items-center gap-8 p-3">
                <div class="px-3 text-sm font-medium"
                    :class="{
                        'text-green-700 dark:text-green-300': notification.type === 'success',
                        'text-yellow-700 dark:text-yellow-300': notification.type === 'warning',
                        'text-red-700 dark:text-red-300': notification.type === 'error',
                        'text-blue-700 dark:text-blue-300': notification.type === 'info'
                    }"
                    x-text="notification.message"></div>

                <flux:button class="text-neutral-500 hover:text-red-500" size="xs" variant="ghost" icon="x-mark"
                    x-on:click="removeMessage(notification.id)" />
            </div>

            <div class="h-1 bg-neutral-100 dark:bg-neutral-900">
                <div class="h-full transition-all duration-[50ms] ease-linear"
                    :class="{
                        'bg-green-300 dark:bg-green-700': notification.type === 'success',
                        'bg-yellow-300 dark:bg-yellow-700': notification.type === 'warning',
                        'bg-red-300 dark:bg-red-700': notification.type === 'error',
                        'bg-blue-300 dark:bg-blue-700': notification.type === 'info'
                    }"
                    :style="`width: ${notification.progressWidth}%;`">
                </div>
            </div>
        </div>
    </template>

</div>
