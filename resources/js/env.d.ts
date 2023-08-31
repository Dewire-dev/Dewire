/// <reference types="vite/client" />

interface ImportMetaEnv {
    readonly VITE_APP_ENV: "local" | "testing" | "staging" | "production";
    // more env variables...
}

interface ImportMeta {
    readonly env: ImportMetaEnv;
}
