<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div
        class="spis-login d-flex align-items-center justify-content-center min-vh-100"
    >
        <div class="card spis-card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <!-- Brand -->
                <div class="text-center mb-4">
                    <div class="spis-badge mx-auto mb-3">
                        <img
                            src="/img/capiz-logo.png"
                            alt="Capiz"
                            style="width: 100px; height: 100px"
                            class="mb-4"
                        />
                    </div>
                    <h1 class="spis-title mb-1">SPIS</h1>
                    <p class="text-muted small mb-0">
                        Sangguniang Panlalawigan Information System
                    </p>
                </div>

                <!-- Validation summary (Laravel session errors) -->
                <div
                    v-if="Object.keys(form.errors).length"
                    class="alert alert-danger py-2 small mb-3"
                >
                    Please check the fields below and try again.
                </div>

                <form @submit.prevent="submit" novalidate>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.email }"
                            autocomplete="username"
                            autofocus
                            required
                        />
                        <div v-if="form.errors.email" class="invalid-feedback">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label"
                            >Password</label
                        >
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.password }"
                            autocomplete="current-password"
                            required
                        />
                        <div
                            v-if="form.errors.password"
                            class="invalid-feedback"
                        >
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Remember + forgot -->
                    <div
                        class="d-flex justify-content-between align-items-center mb-4"
                    >
                        <div class="form-check">
                            <input
                                id="remember"
                                type="checkbox"
                                v-model="form.remember"
                                class="form-check-input"
                            />
                            <label for="remember" class="form-check-label small"
                                >Remember me</label
                            >
                        </div>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="small spis-link"
                        >
                            Forgot password?
                        </Link>
                    </div>

                    <button
                        type="submit"
                        class="btn spis-btn w-100"
                        :disabled="form.processing"
                    >
                        <span
                            v-if="form.processing"
                            class="spinner-border spinner-border-sm me-2"
                        ></span>
                        Log in
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        canResetPassword: { type: Boolean, default: false },
    },
};
</script>

<style scoped>
/* SPIS design tokens: navy / amber / paper */
.spis-login {
    --spis-navy: #1b2a4a;
    --spis-navy-dark: #12203a;
    --spis-amber: #c9982f;
    --spis-paper: #f7f5f0;
    background: var(--spis-paper);
    padding: 1.5rem;
}

.spis-card {
    width: 100%;
    max-width: 420px;
    border-radius: 0.75rem;
}

.spis-badge {
    width: 48px;
    height: 48px;
    border-radius: 0.5rem;
    background: var(--spis-navy);
    color: var(--spis-amber);
    font-weight: 700;
    font-family: "Source Serif 4", serif;
    display: flex;
    align-items: center;
    justify-content: center;
}

.spis-title {
    font-family: "Source Serif 4", serif;
    color: var(--spis-navy);
    font-weight: 700;
    letter-spacing: 0.02em;
}

.spis-btn {
    background: var(--spis-navy);
    color: #fff;
    font-weight: 500;
}
.spis-btn:hover:not(:disabled) {
    background: var(--spis-navy-dark);
    color: #fff;
}
.spis-btn:disabled {
    opacity: 0.7;
}

.spis-link {
    color: var(--spis-navy);
    text-decoration: none;
}
.spis-link:hover {
    color: var(--spis-amber);
    text-decoration: underline;
}
</style>
