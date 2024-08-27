import { router } from "@inertiajs/vue3";

export const dashboard = () => router.get(route("dashboard.users.index"))
export const profile = () => router.get(route("profile.index"))
export const portal = () => router.get(route("portal.post.index"))
export const logout = () => router.post(route("logout"))
