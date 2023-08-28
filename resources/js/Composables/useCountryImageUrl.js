import useImageUrl from "@/Composables/useImageUrl";

export default function useCountryImageUrl(countryCode) {
    const baseUrl = useImageUrl(`country-${countryCode.toLowerCase()}.svg`, '/vendor/blade-flags/').imageUrl;
    console.log(baseUrl);
    return {
        imageUrl: baseUrl,
    };
}
