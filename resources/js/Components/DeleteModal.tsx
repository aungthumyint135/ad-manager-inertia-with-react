import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
  } from "@/components/ui/alert-dialog";
import { router } from '@inertiajs/react';

  import { Button } from "@/components/ui/button";
import {useState} from "react";

  export function DeleteModal({title,confirmText,uuid, open}) {

      const deleteAction = () => {
          router.delete(route('users.destroy',uuid));

      }
    return (
      <AlertDialog>
        {/* Trigger */}
        <AlertDialogTrigger >
          <span>Delete</span>
        </AlertDialogTrigger>

        {/* Modal Content */}
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>{title}</AlertDialogTitle>
            <AlertDialogDescription>
              {confirmText}
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Cancel</AlertDialogCancel>
            <AlertDialogAction onClick={deleteAction}>Confirm</AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    );
  }
