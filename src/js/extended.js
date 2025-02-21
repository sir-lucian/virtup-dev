function goToTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera

    const currentURL = window.location.href;
    const urlWithoutHash = currentURL.split('#')[0];
    window.history.replaceState({}, document.title, urlWithoutHash);
}

function isElementVisible(el) {
    var rect = el.getBoundingClientRect(),
        vWidth = window.innerWidth || document.documentElement.clientWidth,
        vHeight = window.innerHeight || document.documentElement.clientHeight,
        efp = function (x, y) {
            return document.elementFromPoint(x, y);
        };

    // Return false if it's not in the viewport
    if (
        rect.right < 0 ||
        rect.bottom < 0 ||
        rect.left > vWidth ||
        rect.top > vHeight
    )
        return false;

    // Return true if any of its four corners are visible
    return (
        el.contains(efp(rect.left, rect.top)) ||
        el.contains(efp(rect.right, rect.top)) ||
        el.contains(efp(rect.right, rect.bottom)) ||
        el.contains(efp(rect.left, rect.bottom))
    );
}

async function getData(path = undefined) {
    if (!path) {
        return undefined;
    } else {
        try {
            const response = await fetch(path);
            if (response) {
                const data = await response.json();
                if (data && 'data' in data) {
                    return data.data;
                } else {
                    return undefined;
                }
            } else {
                return undefined;
            }
        } catch (e) {
            return undefined;
        }
    }
}

function closeMemberInfo() {
    const body = document.body;
    const fullMemberInfo = document.getElementById('fullMemberInfo');
    const card = document.getElementById('member-card');
    const portrait = document.getElementById('member-portrait');
    fullMemberInfo.style.opacity = '0';
    fullMemberInfo.style.pointerEvents = 'none';
    card.style.transform = 'translateX(-100%)';
    card.style.opacity = '0';
    portrait.style.opacity = '0';
    body.style.height = 'auto';
    body.style.overflowY = 'auto';
}

async function showMemberInfo(index) {
    const body = document.body;
    body.style.height = '100%';
    body.style.overflowY = 'hidden';
    const fullMemberInfo = document.getElementById('fullMemberInfo');
    const fullMemberInfoBody = document.getElementById('fullMemberInfoBody');
    fullMemberInfoBody.innerHTML = '';
    fullMemberInfo.style.opacity = '100%';
    fullMemberInfo.style.pointerEvents = 'auto';
    const members = await getData('/virtup-web/src/json/members.json');
    if (members && Array.isArray(members)) {
        if (members[index] && members[index].youtube.channel_handle) {
            const rawRes = await getData(
                '/virtup-web/services/youtubeService.php?handle=' +
                    members[index].youtube.channel_handle
            );
            const response = rawRes ? await JSON.parse(rawRes) : undefined;
            if (
                response &&
                'items' in response &&
                response.items.length === 1
            ) {
                let viewCount =
                    Number(response.items[0].statistics.viewCount) ?? undefined;
                let subCount =
                    Number(response.items[0].statistics.subscriberCount) ??
                    undefined;

                if (viewCount) {
                    let suffix = '';
                    if (viewCount > 1000000000) {
                        viewCount = viewCount / 1000000000;
                        suffix = 'B';
                    } else if (viewCount > 1000000) {
                        viewCount = viewCount / 1000000;
                        suffix = 'M';
                    } else if (viewCount > 1000) {
                        viewCount = Math.round(viewCount / 1000);
                        suffix = 'k';
                    }
                    viewCount = Math.round(viewCount * 100) / 100;
                    viewCount = viewCount.toString() + suffix;
                }

                if (subCount) {
                    let suffix = '';
                    if (subCount > 1000000000) {
                        subCount = subCount / 1000000000;
                        suffix = 'B';
                    } else if (subCount > 1000000) {
                        subCount = subCount / 1000000;
                        suffix = 'M';
                    } else if (subCount > 1000) {
                        subCount = subCount / 1000;

                        suffix = 'k';
                    }
                    subCount = Math.round(subCount * 100) / 100;
                    subCount = subCount.toString() + suffix;
                }

                const info = {
                    name: members[index].name,
                    handle: members[index].youtube.channel_handle,
                    image_av:
                        '/virtup-web/src/images/virtual-influencers/profile/' +
                        members[index].image_profile,
                    image:
                        '/virtup-web/src/images/virtual-influencers/full/' +
                        members[index].image_full,
                    views: viewCount ?? undefined,
                    subs: subCount ?? undefined,
                    link:
                        'https://www.youtube.com/' +
                        members[index].youtube.channel_handle,
                };

                let memberHTML = '';

                memberHTML += `<img class="member-backdrop" src="${info.image}" id="member-blur" style="opacity: 0; transition: 0.75s ease-in-out;" />`;
                memberHTML += `<img class="member-fullbody" src="${info.image}" id="member-portrait" style="opacity: 0; transition: 0.75s ease-in-out;" />`;
                memberHTML += `<div class="member-profile-card d-flex flex-md-row flex-column justify-content-md-start justify-content-end w-100 h-100">`;
                memberHTML += `<div class="d-flex flex-column justify-content-end text-start mx-md-5 mx-3" id="member-card" style="transform: translateX(-100%); opacity: 0; transition: 0.75s ease-in-out;">`;
                memberHTML += `<div class="w-100-md pb-5 d-flex flex-column gap-2">`;
                memberHTML += `<div>`;
                memberHTML += `<div class="display-4 fw-bold bg-white px-2 py-1" style="width: fit-content;">${info.name}</div>`;
                memberHTML += `</div><div>`;
                memberHTML += `<div class="fs-4 bg-white px-2 py-1 text-secondary" style="width: fit-content;">${info.handle}</div>`;
                memberHTML += `</div>`;
                if (info.subs || info.views) {
                    memberHTML += `<div>`;
                    if (info.subs) {
                        memberHTML += `<div class="bg-white px-2 py-1" style="width: fit-content;"><i class="bi bi-people-fill me-2 text-danger"></i>${info.subs}&nbsp;<small>Subscribers</small></div>`;
                    }
                    if (info.views) {
                        memberHTML += `<div class="bg-white px-2 py-1" style="width: fit-content;"><i class="bi bi-eye-fill me-2 text-danger"></i>${info.views}&nbsp;<small>Views</small></div>`;
                    }
                    memberHTML += `</div>`;
                }
                memberHTML += `<div>`;
                memberHTML += `<a role="button" class="btn btn-danger fs-1 w-100" href="${info.link}" target="_blank"><i class="bi bi-youtube"></i></a></div>`;
                memberHTML += `</div></div></div>`;

                fullMemberInfoBody.innerHTML = memberHTML;

                const card = document.getElementById('member-card');
                const portrait = document.getElementById('member-portrait');
                const blur = document.getElementById('member-blur');
                await delay(100).then(() => {
                    $('#member-card').ready(() => {
                        card.style.transform = 'translateX(0)';
                        card.style.opacity = '1';
                        portrait.style.opacity = '1';
                        blur.style.opacity = '0.5';
                    });
                });
            } else {
                fullMemberInfoBody.innerHTML = `<div class="d-flex flex-column justify-content-center h-100"><div class="d-block mx-auto fw-bold"><i class="bi bi-exclamation-triangle-fill me-2 text-danger fs-5"></i>Failed to get YouTube data</div></div>`;
            }
        }
    } else {
        fullMemberInfoBody.innerHTML = `<div class="d-flex flex-column justify-content-center h-100"><div class="d-block mx-auto fw-bold"><i class="bi bi-exclamation-triangle-fill me-2 text-danger fs-5"></i>Failed to get YouTube data</div></div>`;
    }
}

function delay(time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

async function loadMembers() {
    const members = await getData('/virtup-web/src/json/members.json');
    const membersShow =
        document.getElementById('virtual-influencers') ?? undefined;
    const membersDiv =
        document.getElementById('virtual-influencers-info') ?? undefined;
    if (members && membersShow && membersDiv) {
        membersShow.style.display = 'block';
        let memberHTML = '';
        let group = undefined;
        let groups = [];
        let group_codes = [];
        let indexGroup = 0;
        let indexMember = 0;
        if (Array.isArray(members)) {
            memberHTML +=
                `<div class="d-flex flex-row justify-content-center">`;
            memberHTML +=
                `<h1 class="display-6 pb-3 mb-3 header text-center" id="virtual-influencers-title">Our Virtual Influencers</h1>`;
            memberHTML += `</div>`;
            let member = undefined;
            for (member of members) {
                if (!group_codes.includes(member.group_code)) {
                    groups.push({
                        group_code: member.group_code,
                        group_name: member.group_name,
                    });
                    group_codes.push(member.group_code);
                }
            }
            for (group of groups) {
                memberHTML += `<div class="mt-4">`;
                memberHTML += `<h3 class="h3 text-center mb-0">${group.group_name}</h3>`;
                memberHTML += `<div class="row justify-content-center pt-4">`;
                for (member of members) {
                    if (member.group_code === group.group_code) {
                        memberHTML += `<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 px-2 my-3 d-flex flex-column justify-content-start gap-2"><img src="/virtup-web/src/images/virtual-influencers/profile/${member.image_profile}" class="d-block member-photo" role="button" style="border: solid 2px ${member.color}" alt="${member.name}" onclick="showMemberInfo(${indexMember});" id="member-btn-${indexMember}"} /><div class="d-block text-center"><div class="fw-bold fs-5">${member.name}</div><div class="text-secondary" style="font-size: 1rem;">${member.youtube.channel_handle}</div></div></div>`;
                        indexMember++;
                    }
                }
                memberHTML += `</div>`;
                memberHTML += `</div>`;
                indexGroup++;
                if (indexGroup === groups.length - 1) {
                    memberHTML += `<hr class="w-50 mx-auto my-5" />`;
                }
            }
        }
        membersDiv.innerHTML = memberHTML;
        return Array.isArray(members) ? true : false;
    }
    return false;
}