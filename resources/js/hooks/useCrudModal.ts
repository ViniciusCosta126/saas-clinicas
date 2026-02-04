import { router } from "@inertiajs/react";
import { useState } from "react";
import { route } from "ziggy-js";

export default function useCrudModal<T extends { id: number | string }>() {

    const [isFormModalOpen, setIsFormModalOpen] = useState(false);
    const [selectedData, setSelectedData] = useState<T | null>(null)
    const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
    const [dataToDelete, setDataToDelete] = useState<T | null>(null);
    const [processingDelete, setProcessingDelete] = useState(false);

    const openCreate = () => {
        setSelectedData(null);
        setIsFormModalOpen(true);
    };

    const openEdit = (item: T) => {
        setSelectedData(item);
        setIsFormModalOpen(true);
    };

    const closeFormModal = () => {
        setIsFormModalOpen(false);
        setSelectedData(null);
    };

    const confirmDelete = (item: T) => {
        setDataToDelete(item);
        setIsDeleteModalOpen(true);
    };

    const closeDeleteModal = () => {
        setIsDeleteModalOpen(false);
        setDataToDelete(null);
    };

    const executeDelete = (routeName: string) => {
        if (!dataToDelete) return;

        router.delete(route(routeName, dataToDelete.id), {
            onBefore: () => setProcessingDelete(true),
            onSuccess: () => closeDeleteModal(),
            onFinish: () => setProcessingDelete(false),
            preserveScroll: true,
        });
    };

    return {
        isFormModalOpen,
        selectedData,
        openCreate,
        openEdit,
        closeFormModal,

        isDeleteModalOpen,
        dataToDelete,
        processingDelete,
        confirmDelete,
        closeDeleteModal,
        executeDelete,
    };
}