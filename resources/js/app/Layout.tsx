import { SidebarProvider, SidebarTrigger } from "@/components/ui/sidebar"
import { AppSidebar } from "@/Components/ui/app-sidebar"
import {Link} from "@inertiajs/react";

export default function Layout({ children }: { children: React.ReactNode }) {
    return (
        <SidebarProvider>
            <AppSidebar />
            <main className="w-full bg-gray-100">
                <SidebarTrigger />
                {children}
            </main>


        </SidebarProvider>
    )
}
