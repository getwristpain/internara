import "iconify-icon";

document.addEventListener("livewire:init", () => {
    Livewire.hook("commit", ({ component, respond, succeed, fail }) => {
        // 🔹 Ambil atribut custom dari root element komponen
        let dirtyId = component.el.getAttribute("dirty-id") || null;

        const dispatch = (loading) => {
            window.dispatchEvent(
                new CustomEvent("dirty-loading", {
                    detail: { loading: loading, id: dirtyId },
                })
            );

            if (dirtyId) {
                window.dispatchEvent(
                    new CustomEvent(`dirty-loading:${dirtyId}`, {
                        detail: { loading },
                    })
                );
            }
        };

        // ⏳ Sebelum request dikirim → loading on
        dispatch(true);

        respond(() => {
            // 📥 Response diterima (belum diproses) → biasanya biarkan tetap loading
        });

        succeed(() => {
            // ✅ Request sukses → loading off
            dispatch(false);
        });

        fail(() => {
            // ❌ Request gagal → loading off
            dispatch(false);
        });
    });
});
