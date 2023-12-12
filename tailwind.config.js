module.exports = {
    purge: [
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.vue",
        "./resources/**/*.js"
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                black_cus: {
                    light: "#393F56",
                    default: "#1E212D",
                    dark: "#101218"
                },
                peach_cus: {
                    light: "#F8E9DE",
                    default: "#EABF9F",
                    dark: "#E2A679"
                },
                brown_cus: {
                    // light: "#CEB0A1",
                    // default: "#B68973",
                    // dark: "#A06E54"
                    50: "#110112112",
                    100: "#f8f7f7",
                    200: "#cbc3c3",
                    300: "#9d9090",
                    400: "#6d5f5f",
                    500: "#393232",
                    600: "#312b2b",
                    700: "#2b2626",
                    800: "#231f1f",
                    900: "#1b1818"
                },
                milk_cus: {
                    light: "#FFFFFF",
                    default: "#FAF3E0",
                    dark: "#F4E4B9"
                },
                pink_cus: {
                    light: "#EFA9B1",
                    default: "#E5707E",
                    dark: "#DC4153"
                },
                yellow_cus: {
                    light: "#F7F7DE",
                    default: "#E8E9A1",
                    dark: "#DEE07B"
                },
                orange_cus: {
                    // light: "#F1D5A7",
                    // default: "#E6B566",
                    // dark: "#E0A23E",
                    50: "#100102103",
                    100: "#fdf5f2",
                    200: "#f7d8ca",
                    300: "#f0baa3",
                    400: "#eba080",
                    500: "#e48258",
                    600: "#d75923",
                    700: "#9e4119",
                    800: "#652a10",
                    900: "#2c1207"
                },
                green_cus: {
                    //     light: "#D2EEE6",
                    //     default: "#A3DDCB",
                    //     dark: "#79CDB3"
                    50: "#10f10810b",
                    100: "#f5f9f8",
                    200: "#bfd9ce",
                    300: "#8bbba6",
                    400: "#59977c",
                    500: "#3a6452",
                    600: "#315445",
                    700: "#264035",
                    800: "#1c3028",
                    900: "#13201a"
                },
                skin_cus: {
                    50: "#fcfcf7",
                    100: "#fbfaf3",
                    200: "#f9f6ec",
                    300: "#f6f3e4",
                    400: "#f4efdc",
                    500: "#f2eed9",
                    600: "#d9cb8c",
                    700: "#c0a93f",
                    800: "#736526",
                    900: "#26220d"
                }
            },
            minHeight: {
                10: "10rem"
            },
            maxWidth: {
                18: "18rem"
            }
        }
    },
    variants: {
        extend: {}
    },
    plugins: []
};
