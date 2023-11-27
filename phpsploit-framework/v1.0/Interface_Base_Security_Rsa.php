<?php
/**
 * Created by PhpStorm.
 * User: huc0day
 * Date: 23-2-23
 * Time: 下午1:24
 */

/*
=======================================================================================================
Phpsploit-Framework is an open source CTF framework and vulnerability exploitation development library.
Copyright (C) 2022-2023, huc0day (Chinese name: GaoJian).
All rights reserved.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY;   without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.    If not, see <https://www.gnu.org/licenses/>.
=======================================================================================================
 */

interface Interface_Base_Security_Rsa extends Interface_Base
{
    const  ALGORITHM_KEY         = "RSA";
    const  ALGORITHM_CIPHER      = "RSA/ECB/PKCS1Padding";
    const  ALGORITHM_SIGNATURE   = "MD5withRSA";
    const  SIZE_MAX_ENCODE_BLOCK = 245;
    const  SIZE_INIT_KEY_PAIR    = 2048;
    const  SIZE_MAX_DECODE_BLOCK = 256;

    const   CLIENT_PRIVATE_KEY_SIZE = self::SIZE_INIT_KEY_PAIR;
    const   CLIENT_PUBLIC_KEY       = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAr+/Bs8D4zLwgFd9zX4g+" .
                                      "Ec/HgjjZGbONdD6khPo+A2YGzYHEw/C/B+5m5H+lF74l00opeRSJIJ8pwWPtsfHH" .
                                      "ugMqqIz5hNTPwZlXM3KIcy+uTYRETIhfkOyayOD9EitR0ynZW+1wxW1MDDSDPrAv" .
                                      "3PYpzDXO7TSXkrBCEpHigNzpRqeq5gn2rlPstGefFR0K87/A/3SYSx5e8c2IuiPd" .
                                      "SlPy7sEphmA/kPky1V7rjpI5OrgW1/zrgn2AQJitBsslTZ/Pfmf+oe906Ry0FQfZ" .
                                      "qmD5bkufkztmUQV3zk+96yR3woe7HV6ObeXs+CtBgM1uUqF70+1kpvY8GWDfuvBy" .
                                      "ewIDAQAB";
    const   CLIENT_PRIVATE_KEY      = "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCv78GzwPjMvCAV" .
                                      "33NfiD4Rz8eCONkZs410PqSE+j4DZgbNgcTD8L8H7mbkf6UXviXTSil5FIkgnynB" .
                                      "Y+2x8ce6AyqojPmE1M/BmVczcohzL65NhERMiF+Q7JrI4P0SK1HTKdlb7XDFbUwM" .
                                      "NIM+sC/c9inMNc7tNJeSsEISkeKA3OlGp6rmCfauU+y0Z58VHQrzv8D/dJhLHl7x" .
                                      "zYi6I91KU/LuwSmGYD+Q+TLVXuuOkjk6uBbX/OuCfYBAmK0GyyVNn89+Z/6h73Tp" .
                                      "HLQVB9mqYPluS5+TO2ZRBXfOT73rJHfCh7sdXo5t5ez4K0GAzW5SoXvT7WSm9jwZ" .
                                      "YN+68HJ7AgMBAAECggEAChzW3nUuF96MXZV9dTVIlA+EYTjRScfnTpI3NKmJnPpl" .
                                      "U7Ss0bJp2JPceC/aFnZIiE+P+LS0eRqM9N/AjuTd3RRHhG6t/POaiX894ugnba+E" .
                                      "7lG290szawoej4NXKI8y4dda9gy82axBncX68USBS8sede112m6Wc8kL0zNteIih" .
                                      "siMIlASgt1gF6ay7AaA/8axteR1/ON1BpKUnwEENDh/Da5WbswNPfaRDacOXYv30" .
                                      "9cvqxhKAmT6qfrzT4uRikPH1i0UEgFF840iMJI/dp6pzfC1znT86ERtMRT1pzblB" .
                                      "LxZfeEwKjv6BM8pBx09deq9mh/wQt8swQoyg9oiwuQKBgQDh3LVGuCt4ix8/3X6s" .
                                      "fJz7HHz6a1xieWHo7977Hkv7yzo3jOD3ShEZPrv6xUrn/EVa3VNVUWQ8pCgIp6aV" .
                                      "J9THm2y6pNNC43YSwcf0zKL3U370SFY1nonpG0CUF+qR+lmzGya3t79+onKOQ4ED" .
                                      "CdNHBfcTxvy3cjOlKhav3rMwxwKBgQDHaaAc4xnFSsZ/MR2AVUWUKVRd9A3bi7TQ" .
                                      "q8YoqZWZpwEpc5xsGBYqibXGGCo55hHiQVXELUey5S4APBehxyiOZmPXq/FO/Mr8" .
                                      "18o3+EUzYLrMOWYr3Lb48KFjtbyzCHAMvBGIJHt2EetfF+vadYpO2ROGD+PI3/RD" .
                                      "f9hjs5+krQKBgAbbss1w7jD82HgR+7S1G/csCEd6VxXOZcCy9+xcISaGJ0BkkLgx" .
                                      "kY9YrlCRCRM+P8Tgj5U5oXeN7IFGxfIlgXqGJ6kLNDcFvSIYrD+srw4fhO1Z/PQn" .
                                      "2jwvzagxibfhCDQ+ENDnTXNE74GOXy5+b+HqNnRtSGMxnovXWVUByCMlAoGAGCTq" .
                                      "1PSORzwBgp7wwnwQm5rRczq8fsuQjf9uU7gMu/jjhCBSXSghbu8TijOc0TvRCIL+" .
                                      "nm0ZFEj5Y9/iwJy7hVpSVmekJPsonKqH+nTd9BWPKHD+tOrZYJTKBaeYfFjWMESJ" .
                                      "HuHD7QzIYdAkp2O55kgUPBQqcUTkb1PIYHH8L1UCgYBk/KO7ULeeYaoCmg1YEUae" .
                                      "Lyhe7Enci3g1LHOjd8npdgtx0yCpgapEkpAOQLHoUmSreLl9g6BQLqGjfQMg9qEs" .
                                      "5VNKXQXDjNgSDAtCCGClFv8u04fYxCZwzpM6LCUPfP0tQ/9SK6DzCMP0/vJjmZnD" .
                                      "4zrWqNLuzGmeReQyiQLZCA==";
    const   SERVER_PRIVATE_KEY_SIZE = self::SIZE_INIT_KEY_PAIR;
    const   SERVER_PUBLIC_KEY       = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArJy0OKzjSBrotctJBwCe" .
                                      "3B1FrgZ9/cjzueHU3NpA4P5X9pIQ8wDf23bsqbUrVqqk773ri2pSle+iFDHubdU4" .
                                      "eJMujl8eH1TmA7vt9kOlQTNKPHCX3AY+87PlQsnqDt5ABNd7Mo7wsDNuYgC/2U2s" .
                                      "5EjifqgNRV3d/3l/DWVu+578eD006Xf87bHc3AjqkWletFPKX/4qRnHttt+smjQg" .
                                      "aWOQmsVNGCRC27jWb5pZVrnWVxHNnhwAbWTlTHokCIDg+wSWtspSmaBL1PvQWAyD" .
                                      "Q/D8zeo7I+kQSAhkYsVxckrqNZBCsPLtH7edXEplvGiHc1/5tnROtyLT06ER+VzN" .
                                      "KQIDAQAB";
    const   SERVER_PRIVATE_KEY      = "MIIEwAIBADANBgkqhkiG9w0BAQEFAASCBKowggSmAgEAAoIBAQCsnLQ4rONIGui1" .
                                      "y0kHAJ7cHUWuBn39yPO54dTc2kDg/lf2khDzAN/bduyptStWqqTvveuLalKV76IU" .
                                      "Me5t1Th4ky6OXx4fVOYDu+32Q6VBM0o8cJfcBj7zs+VCyeoO3kAE13syjvCwM25i" .
                                      "AL/ZTazkSOJ+qA1FXd3/eX8NZW77nvx4PTTpd/ztsdzcCOqRaV60U8pf/ipGce22" .
                                      "36yaNCBpY5CaxU0YJELbuNZvmllWudZXEc2eHABtZOVMeiQIgOD7BJa2ylKZoEvU" .
                                      "+9BYDIND8PzN6jsj6RBICGRixXFySuo1kEKw8u0ft51cSmW8aIdzX/m2dE63ItPT" .
                                      "oRH5XM0pAgMBAAECggEBAKlapkfk+KnKHQAgj2nbZgG4hqETpZHWE6sQs3RsfrNB" .
                                      "WLSG4zJIbVo5+EEZi4fgrSq7P9rtWlHZZ0BBLRl91YYXgdoV4MwE1Bhdzj+MZxrt" .
                                      "Y6yhG524UxNwMUOyL36e+FjHwgv8ypFWJLrq2VAvMa5ZBEAYSc0BJ8p8Pfe6yYT8" .
                                      "/15/ZcU1k5G5GQF8nF7DVKmZOtrIYqsuPHQhL+7EpHEPw+YOJKDeXmPvxzfxYx6C" .
                                      "ScA5ROFsJOpTB7S5UkL0KsZvmmCB7ipKUS6qVo+Jo7n3c+ReSbTP9xuLP/8fifyp" .
                                      "hI+lS2ov2kA42lJ4Fgk8I+h+RuCRY212yyH0Yfu48MECgYEA0/G2CitfVIrXNmso" .
                                      "u+cLP7atMzubioUrGpTv4pIGhgfdXh87wOVL2bnOd3OJxneqEtMUgEEdbvHfC9lF" .
                                      "WDk3A0fQ14C/+Ro6GjxN6RbkCR0hP/nlQi4VCoNgNevlCddlmrbDEEMn96xqn/6o" .
                                      "DjWqgBBtyOa6qm4hWp6ZJZxr6E0CgYEA0H3/NhAldWlxzX7aCyuedjXT7ZW6nyrf" .
                                      "weBBBi6itI4xqV+9S1rCHj4H8qExOXNutaqcwiIVG/m3LZWqI12/PrDiLI3aAWnl" .
                                      "5rYko0soj0k+zz0WEWzY/dbdvYMoKPAhVAubKcylqO3FLyKa70H/9ItXCFFfVD+6" .
                                      "db+VW0hepk0CgYEAtVxQecNDgASOxHJOGPxME+ktrHmFT7NEfyqTWz25d1ejhbcU" .
                                      "WqvbjCQDGRQ1AS/EyPb2xAj0NsuiIXF6dVQATz5U5xO1MmPO9ERGJv7/gwz6NtSP" .
                                      "6WGlf6mL2phRFWrL9ugNYw0UVkujseUnyYECtTNZvmAxu0UiJXkxc422iMECgYEA" .
                                      "v8IzGhFtsnjCL+QtPbrnqwfFHS7qj3yKgrH0fHAmO/TQnlytKQKXqeMZwkIZmSKf" .
                                      "P71lInTgf3OE1AtkidSukkV0MNBjI4u35SO/vOTisC8I8ujXRD2dspKOLcDVDhoW" .
                                      "PUvTcXWFJENUag7k+4vzk4MZEFBvYnie0a/c+jEsxL0CgYEAzRMAM9wNPrwcOfm4" .
                                      "SiyjdEpDaGfEI6ywdv79koIsV1UjTSeBA9pRW4002giY97EbWHfoBgbBuosBEhF8" .
                                      "s2wt/d/5oOzJzaplGBWnnwfsZ2nO1l4jagZVITHo1kKVVR1/gCUBKyHG1YN73T0k" .
                                      "zP5a/aenVuzsG3mqTWlVYXcC8c4=";
}