<div x-data="{
        // Opciones
        position: 'bottom-end', // 'top-start', 'top-end', 'bottom-start', 'bottom-end'
        autoClose: true,
        autoCloseDelay: 5000,

        // Helpers
        notifications: [],
        nextId: 1,

        // Setea las clases de transición basadas en la posición
        transitionClasses: {
            'x-transition:enter-start'() {
                if (this.position === 'top-start' || this.position === 'bottom-start') {
                    return 'opacity-0 -translate-x-12 rtl:translate-x-12';
                } else if (this.position === 'top-end' || this.position === 'bottom-end') {
                    return 'opacity-0 translate-x-12 rtl:-translate-x-12';
                }
            },
            'x-transition:leave-end'() {
                if (this.position === 'top-start' || this.position === 'bottom-start') {
                    return 'opacity-0 -translate-x-12 rtl:translate-x-12';
                } else if (this.position === 'top-end' || this.position === 'bottom-end') {
                    return 'opacity-0 translate-x-12 rtl:-translate-x-12';
                }
            },
        },

        // Dispara una notificación
        toast(message, type, link) {
            const id = this.nextId++;

            this.notifications.push({ id, message, type, link, visible: false });

            setTimeout(() => {
                const index = this.notifications.findIndex(n => n.id === id);

                if (index > -1) {
                    this.notifications[index].visible = true;
                }
            }, 30);

            if (this.autoClose) {
                setTimeout(() => this.dismissNotification(id), this.autoCloseDelay);
            }
        },

        // Descartar una notificación
        dismissNotification(id) {
            const index = this.notifications.findIndex(n => n.id === id);

            if (index > -1) {
                this.notifications[index].visible = false;

                setTimeout(() => {
                    this.notifications.splice(index, 1);
                }, 300);
            }
        }
    }"
    x-on:toast.window="toast($event.detail.message, $event.detail.type, $event.detail.link)"
>
    <div
        x-cloak
        x-show="notifications.length > 0"
        role="region"
        aria-label="Notifications"
        class="fixed z-50 flex w-80 gap-2"
        :class="{
            'flex-col-reverse': position === 'top-start' || position === 'top-end',
            'flex-col': position === 'bottom-start' || position === 'bottom-end',
            'top-4': position === 'top-end' || position === 'top-start',
            'bottom-4': position === 'bottom-end' || position === 'bottom-start',
            'end-4': position === 'top-end' || position === 'bottom-end',
            'start-4': position === 'top-start' || position === 'bottom-start',
        }"
    >
        <template x-for="notification in notifications" :key="notification.id">
            <div
                x-show="notification.visible"
                x-bind="transitionClasses"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                class="flex items-center justify-between gap-2 px-3 py-4 rounded-xl shadow-lg"
                :class="{
                    'bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-950 dark:border-emerald-700 dark:text-emerald-100':
                        notification.type === 'success',
                    'bg-red-50 border-red-200 text-red-800 dark:bg-red-950 dark:border-red-700 dark:text-red-100':
                        notification.type === 'error',
                    'bg-yellow-50 border-yellow-200 text-yellow-800 dark:bg-yellow-950 dark:border-yellow-700 dark:text-yellow-100':
                        notification.type === 'warning',
                    'bg-sky-50 border-sky-200 text-sky-800 dark:bg-sky-950 dark:border-sky-700 dark:text-sky-100':
                        notification.type === 'info',
                    'bg-white border-zinc-200 text-zinc-800 dark:bg-zinc-950 dark:border-zinc-700 dark:text-zinc-100':
                        notification.type === 'neutral',
                }"
                role="alert"
                :aria-live="notification.type === 'error' ? 'assertive' : 'polite'"
            >
                <template x-if="notification.type !== 'neutral'">
                    <div
                        class="flex size-8 flex-none items-center justify-center rounded-full"
                    >
                        <template x-if="notification.type === 'success'">
                            <i class="ki-filled ki-check-circle text-2xl text-emerald-600"></i>
                        </template>

                        <template x-if="notification.type === 'error'">
                            <i class="ki-filled ki-cross-circle text-2xl text-red-600"></i>
                        </template>

                        <template x-if="notification.type === 'warning'">
                            <i class="ki-filled ki-information-1 text-2xl text-yellow-600"></i>
                        </template>

                        <template x-if="notification.type === 'info'">
                            <i class="ki-filled ki-information-2 text-2xl text-sky-600"></i>
                        </template>
                    </div>
                </template>
                <div class="">
                    <div x-text="notification.message" class="text-sm font-medium text-zinc-800 dark:text-zinc-200"></div>
                </div>
                <flux:button
                    @click="dismissNotification(notification.id)"
                    size="sm"
                    variant="subtle"
                    icon="x-mark"
                    class="!flex-none"
                    square
                />
            </div>
        </template>
    </div>
</div>
